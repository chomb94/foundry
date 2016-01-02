<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Form\Type\StepType;
use AppBundle\Form\Type\ParticipateType;
use AppBundle\Entity\Project;
use AppBundle\Entity\UserGoogle;
use AppBundle\Entity\Vote;
use AppBundle\Entity\Step;
use AppBundle\Entity\CreditsHistory;
use AppBundle\Entity\UserCredits;
use AppBundle\Base\BaseController;

class ProjectController extends BaseController
{
    /**
     * @Route("/project/view/{id}", name="projectView")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function viewAction(Request $request, $id)
    {
        $project     = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $user        = $this->getUser();
        $user_id     = $user->getId();
        $myproject   = ($user_id == $project->getUser()->getId());
        $step_list   = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $id]);
        $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $project]);

        $user_credits = null;
        if ($user_id != 0) {
            $user_credits = $this->get("doctrine")->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user_id])[0];
        } else {
            $user_credits = new UserCredits();
            $user_credits->setCredits(10);
        }

        // Rewrite video url if it not contain "embed" for youtube
        $videoUrl = $project->getVideoUrl();
        if (($videoUrl != "" ) && !(strpos($videoUrl, 'embed'))) {

            if (strpos($videoUrl, 'watch')) {
                $posId = strrpos($videoUrl, "=");
            } elseif (strpos($videoUrl, 'youtu')) {
                $posId = strrpos($videoUrl, "/");
            }

            $videoId     = substr($videoUrl, $posId + 1, strlen($videoUrl));
            $newVideoUrl = "https://www.youtube.com/embed/".$videoId;
            $project->setVideoUrl($newVideoUrl);
        }

        // Show participants
        $participants = $this->get("doctrine")->getRepository("AppBundle:Project")->participants($project);
        $project->setStepsAndCredits($step_list, $all_credits);

        return [
            'project'     => $project,
            'family'      => $project->getfamily(),
            'myproject'   => $myproject,
            'userCredits' => $user_credits,
            'steps'       => $project->getSteps(),
            'error'       => $request->get("error", 0),
            'user'        => $user,
            'participants'  => $participants,
        ];
    }

    /**
     * @Template()
     */
    public function viewVoteAction($id)
    {
        $user    = $this->getUser();
        $project = $this->getDoctrine()->getRepository("AppBundle:Project")->find($id);

        if (is_null($project)) {
            throw $this->createNotFoundException();
        }

        $vote = !$user ? null : $this
              ->getDoctrine()
              ->getRepository("AppBundle:Vote")
              ->findByUserAndProject($user, $project)
        ;

        return [
            'readonly' => is_null($this->getUser()),
            'id'       => $id,
            'vote'     => $vote,
        ];
    }

    /**
     * @Route("/project/{id}/vote", name="projectVote")
     * @Security("has_role('ROLE_USER')")
     */
    public function projectVoteAction($id)
    {
        $user    = $this->getUser();
        $project = $this->getDoctrine()->getRepository("AppBundle:Project")->find($id);
        $family = $project->getFamily();
        if ( !is_null($family) ) {
           $family_isActive  = $family->isActive();
        } else {
            $family_isActive = true;
        }

        if (is_null($project) || !$project->isActive() || !$family_isActive) {
            throw $this->createNotFoundException();
        }

        $vote = !$user ? null : $this
              ->getDoctrine()
              ->getRepository("AppBundle:Vote")
              ->findByUserAndProject($user, $project)
        ;

        if ($user) {
            $em = $this->getDoctrine()->getManager();
            if ($vote) {
                $em->remove($vote);
            } else {
                // Check with max_votes
                $max_votes = $family->getMaxVotes();
                $user_nb_votes = $this
                      ->getDoctrine()
                      ->getRepository("AppBundle:Vote")
                      ->countByUserAndFamily($user, $family);
                if( ($user_nb_votes < $max_votes) || ($max_votes == null) || ($max_votes < 1) )
                {
                    // If < max_votes : save vote
                    $vote = new Vote();
                    $vote->setUser($user);
                    $vote->setProject($project);
                    $em->persist($vote);
                }
            }
            $em->flush();
        }

        return $this->forward('AppBundle:Project:viewVote', ['id' => $id]);
    }

    /**
     * @Route("/project/{id}/pledge", name="projectPledge")
     * @Security("has_role('ROLE_USER')")
     */
    public function pledgeAction(Request $request, $id)
    {
        $user         = $this->getUser();
        $user_id      = $user->getId();
        $project      = $this->getDoctrine()->getRepository("AppBundle:Project")->find($id);
        $user_credits = $this->getDoctrine()->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user_id])[0];

        if (is_null($project) || !$project->isActive()) {
            throw $this->createNotFoundException();
        }

        if ($user_credits->getCredits() - $request->get("price") < 0) {
            return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'error' => 1]);
        }

        $this->pledgeProject($user, $user_credits, $project, $request->get('price'));
        $this->success("Your pledge has been taken into account.");
        // Send mail to project owner
        if ($this->getUser()) {
            $this->get('app.mail')->send(
               $project->getUser(), 'New Pledge !', 'AppBundle:Email:newPledge.html.twig', [
                // context required by the template, except subject and user which are already available
                'project' => $project,
               ]
            );
        }

        return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'user' => $user]);
    }

    /**
     * @Route("/project/list", name="projectList")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function listAction()
    {
        $user     = $this->getUser();
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findByUser($user);

        foreach ($projects as $oneProject) {
            $step_list   = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $oneProject->getId()]);
            $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $oneProject]);
            $oneProject->setStepsAndCredits($step_list, $all_credits);
        }

        return [
            'menu_myprojects' => 'active',
            'projects'        => $projects,
            'user'            => $user,
        ];
    }

    /**
     * @Route("/project/{id}/edit", name="projectEdit")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $user         = $this->getUser();
        $project_init = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);

        if ($project_init->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }

        $form    = $this->createForm(new ProjectType(), $project_init);

        $context = [
            'form'       => $form->createView(),
            'menu_start' => 'active',
            'user'       => $user,
            'project'    => $project_init,
        ];

        if ($this->isFragment($request)) {
            return $this->render('AppBundle:Project:editForm.html.twig', $context);
        }

        $form->handleRequest($request);
        $project = $form->getData();

        if ($form->isValid()) {
            $project->setCreationDate(new \DateTime());
            $project->setUser($user);
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($project);
            $manager->flush();

            $this->success("Your project updates have been saved.");

            return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'user' => $user]);
        }

        return $context;
    }

    /**
     * @Route("/project/{id}/delete", name="projectDelete")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->get("doctrine")->getRepository("AppBundle:Project");
        $project    = $repository->find($id);

        if (!$project) {
            throw $this->createNotFoundException();
        }

        if ($project->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        // An empty form generates a CRSF token anyway :)
        $form = $this
           ->createFormBuilder()
           ->add('submit', 'submit', array(
               'label' => 'Confirm',
               'attr'  => array(
                   'class' => 'btn btn-danger',
               ),
           ))
           ->getForm()
        ;

        if ($request->isMethod('POST') && $form->handleRequest($request) && $form->isValid()) {
            $repository->delete($project);

            $this->success("Your project have been deleted.");

            return $this->redirectToRoute('homepage');
        }

        return [
            'project' => $project,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route("/project/publish/{family_id}", name="projectPublish")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function publishAction(Request $request, $family_id)
    {
        $project = new Project();
        // Default family
        if ($family_id == 0) {
            $family_id = 1;
        }
        $family  = $this->getDoctrine()->getRepository("AppBundle:Family")->find($family_id);
        $project->setFamily($family);
        // Max 90 days - defaut 90
        if ($family->getEndDate() <> null) {
            $project->setEndDate($family->getEndDate());
        } else {
            $project->setEndDate(new \DateTime(date("Y-m-d", time() + 60 * 60 * 24 * project::MAX_DURATION)));
        }
        $form    = $this->createForm(new ProjectType(), $project);
        $form->handleRequest($request);
        $user    = $this->getUser();

        $context = [
            'family'     => $family,
            'form'       => $form->createView(),
            'menu_start' => 'active',
            'user'       => $user,
        ];

        if ($this->isFragment($request)) {
            return $this->render('AppBundle:Project:publishForm.html.twig', $context);
        }

        if ($form->isValid()) {
            $project->setCreationDate(new \DateTime());
            $project->setUser($user);
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($project);
            $manager->flush();

            $this->success("Your project have been published.");

            // Send an email to family owner
            if ($this->getUser()) {
                $this->get('app.mail')->send(
                   $family->getUser(), 'New Project in "'.$family->getName().'"!', 'AppBundle:Email:newProject.html.twig', [
                    // context required by the template, except subject and user which are already available
                    'project' => $project,
                    'family' => $family,
                   ]
                );
            }

            //return $this->redirectToRoute('projectStepPublish', ['id' => $project->getId(), 'user' => $user]);
            return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'user' => $user]);
        }

        return $context;
    }

    /**
     * @Route("/project/step/{id}/edit", name="projectStepEdit")
     * @Security("has_role('ROLE_USER')")
     * @Template("AppBundle:Project:step.html.twig")
     */
    public function stepEditAction(Request $request, $id)
    {
        $step_init  = $this->get("doctrine")->getRepository("AppBundle:Step")->find($id);
        $user       = $this->getUser();
        $form       = $this->createForm(new StepType(), $step_init);
        $form->handleRequest($request);
        $step       = $form->getData();
        $project_id = $step_init->getProjectId();
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($project_id);

        if ($project->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }

        if ($form->isValid()) {
            $step->setCreationDate(new \DateTime());
            $step->setProjectId($project_id);
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($step);
            $manager->flush();

            $this->success("Your step updates have been saved.");
        }

        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $project_id]);

        return [
            'form'            => $form->createView(),
            'project'         => $project,
            'steps'           => $step_list,
            'user'            => $user,
            'menu_myprojects' => 'active',
        ];
    }

    /**
     * @Route("/user/project/{id}/steps/publish", name="projectStepPublish")
     * @Security("has_role('ROLE_USER')")
     * @Template("AppBundle:Project:step.html.twig")
     */
    public function stepPublishAction($id, Request $request)
    {
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $project_id = $project->getId();
        $user       = $this->getUser();
        $user_id    = $user->getId();


        if ($project->getUser()->getId() != $user_id) {
            throw $this->createAccessDeniedException();
        }

        $step = new Step();
        $step->setEndDate(new \DateTime(date("Y-m-d", time() + 60 * 60 * 24 * project::MAX_DURATION)));
        $form = $this->createForm(new StepType(), $step);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $step->setCreationDate(new \DateTime());
            $step->setProjectId($project->getId());
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($step);
            $manager->flush();

            $this->success("Your step have been published.");
        }

        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $project_id]);

        return [
            'form'            => $form->createView(),
            'project'         => $project,
            'steps'           => $step_list,
            'menu_myprojects' => 'active',
            'user'            => $user,
        ];
    }

    /**
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function viewParticipateModalAction(Request $request, $id)
    {
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $user       = $this->getUser();

        if (is_null($project)) {
            throw $this->createNotFoundException();
        }

        return [
            'id'            => $id,
            'userCredits'   => $this->get("doctrine")->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user->getId()])[0],
        ];
    }

    /**
     * @Template()
     * @Route("/project/participate/{id}", name="projectParticipate")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewParticipateAction(Request $request, $id, $imInButton = true)
    {
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $user       = $this->getUser();

        if (is_null($project)) {
            throw $this->createNotFoundException();
        }

        $isParticipant = $this
           ->get("doctrine")
           ->getRepository("AppBundle:CreditsHistory")
           ->findBy([
               'user_id' => $user->getId(),
               'project' => $project
           ]) ?: false;

        $message = null;

        $amount = $request->request->get('price');
        if ($amount > 0) {
            $credits = $this
               ->getDoctrine()
               ->getRepository("AppBundle:UserCredits")
               ->findOneBy(['user_id' => $user->getId()]);

            if (!$credits || $credits->getCredits() - $amount < 0) {
                $message = sprintf("You have %d!", $credits->getCredits());
            } else {
                $this->pledgeProject($user, $credits, $project, $amount);

                return $this->redirectToRoute('projectParticipate', ['id' => $id]);
            }
        }

        return [
            'id'            => $id,
            'message'       => $message,
            'isParticipant' => $isParticipant,
            'imInButton'    => $imInButton,
            'userCredits'   => $this->get("doctrine")->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user->getId()])[0],
        ];
    }

    protected function pledgeProject(UserGoogle $user, UserCredits $credits, Project $project, $amount)
    {
        $em = $this->getDoctrine()->getManager();

        $creditHistory = new CreditsHistory();
        $creditHistory->setUserId($user->getId());
        $creditHistory->setProject($project);
        $creditHistory->setNbCreditsSpent($amount);
        $creditHistory->setPledgeDate(date_create("now"));
        $em->persist($creditHistory);

        $credits->setCredits($credits->getCredits() - $amount);
        $em->persist($credits);

        $em->flush();

        // Send mail to project owner
        if ($this->getUser()) {
            $this->get('app.mail')->send(
               $project->getUser(), 'New Pledge!', 'AppBundle:Email:newPledge.html.twig', [
                // context required by the template, except subject and user which are already available
                'project' => $project,
               ]
            );
        }
    }

    /**
     * @Route("/enable-project-{id}-{enable}", name="enableProject")
     * @Security("has_role('ROLE_USER')")
     */
    public function enableAction($id, $enable)
    {
        $user       = $this->getUser();
        $repository = $this->getDoctrine()->getRepository("AppBundle:Project");
        $project    = $repository->find($id);

        if (is_null($project)) {
            throw $this->createNotFoundException();
        }

        if ($project->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }

        $project->setActive($enable);

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        return $this->redirectToRoute('projectView', array(
               'id' => $id,
        ));
    }
}
