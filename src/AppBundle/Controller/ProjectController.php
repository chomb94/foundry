<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Form\Type\StepType;
use AppBundle\Form\Type\ParticipateType;
use AppBundle\Entity\Project;
use AppBundle\Entity\UserGoogle;
use AppBundle\Entity\Vote;
use AppBundle\Entity\Step;
use AppBundle\Entity\Contributor;
use AppBundle\Base\BaseController;
use AppBundle\Entity\Family;

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

        // Rewrite video url if it not contain "embed" for youtube
        $videoUrl = $project->getVideoUrl();
        if (($videoUrl != "" ) && !(strpos($videoUrl, 'embed'))) {

            if (strpos($videoUrl, 'watch')) {
                $posId = strrpos($videoUrl, "=");
            } elseif (strpos($videoUrl, 'youtu')) {
                $posId = strrpos($videoUrl, "/");
            }

            if (isset($posId)) {
                $videoId     = substr($videoUrl, $posId + 1, strlen($videoUrl));
                $newVideoUrl = "https://www.youtube.com/embed/".$videoId;
                $project->setVideoUrl($newVideoUrl);
            } else {
                $project->setVideoUrl("");
            }
        }

        // Show participants
        $participants = $this->get("doctrine")->getRepository("AppBundle:Project")->participants($project);
        $project->setStepsWithStatus($step_list);

        return [
            'project'     => $project,
            'family'      => $project->getfamily(),
            'myproject'   => $myproject,
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

        if (is_null($family)) {
            $family = new Family();
        }

        $family_isActive  = $family->isActive();

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
                $user_nb_votes = $family->getId() ? $this
                      ->getDoctrine()
                      ->getRepository("AppBundle:Vote")
                      ->countByUserAndFamily($user, $family) : null;
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
     * @Route("/project/{id}/contribute", name="projectContribute")
     * @Security("has_role('ROLE_USER')")
     */
    public function contributeAction($id, Request $request)
    {
        $user         = $this->getUser();
        $project      = $this->getDoctrine()->getRepository("AppBundle:Project")->find($id);

        if (is_null($project) || !$project->isActive()) {
            throw $this->createNotFoundException();
        }


        if ($user) {
            $contribute = $this
              ->getDoctrine()
              ->getRepository("AppBundle:Contributor")
              ->findByUserAndProject($user, $project)
            ;

            if (!$contribute) {
                $em = $this->getDoctrine()->getManager();

                $contributor = new Contributor();
                $contributor->setUser($user);
                $contributor->setProject($project);
                $contributor->setStatus(1); // Actif
                $contributor->setContributionDate(new \DateTime());

                $em->persist($contributor);
                $em->flush();

                $this->success("Your pledge has been taken into account.");
            }
        }

        // Send mail to project owner
        if ($this->getUser()) {
            $this->get('app.mail')->send(
               $project->getUser(), 'New Contributor !', 'AppBundle:Email:newPledge.html.twig', [
                // context required by the template, except subject and user which are already available
                'project' => $project,
               ]
            );
        }

        if ($this->isAjax($request)) {
            return new Response();
        } else {
            return $this->redirectToRoute('projectView', array(
                   'id' => $project->getId(),
            ));
        }
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
     * @Route("/project/{project_id}/step/{step_id}/status/{pourcent}", name="stepSetStatus")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function stepSetStatusAction($project_id, $step_id, $pourcent)
    {
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($project_id);
        $user       = $this->getUser();

        if (is_null($project)) {
            throw $this->createNotFoundException();
        }

        if ($project->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $step = $this->get("doctrine")->getRepository("AppBundle:Step")->findById($step_id)[0];
        if( $step->getProjectId() !== $project->getId()) {
            throw $this->createAccessDeniedException();
        }

        $step->setStatus($pourcent);

        $manager = $this->get("doctrine")->getManager();
        $manager->persist($step);
        $manager->flush();

        return $this->redirectToRoute('projectView', array(
               'id' => $project_id,
        ));
    }

    /**
     * @Route("/project/{project_id}/step/{step_id}/delete", name="stepDelete")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function stepDeleteAction($project_id, $step_id)
    {
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($project_id);
        $user       = $this->getUser();

        if (is_null($project)) {
            throw $this->createNotFoundException();
        }

        if ($project->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $step = $this->get("doctrine")->getRepository("AppBundle:Step")->findById($step_id)[0];
        if( $step->getProjectId() !== $project->getId()) {
            throw $this->createAccessDeniedException();
        }

       $dql = " DELETE AppBundle\Entity\Step s
                WHERE s.id = :id
         ";

        $this
            ->get("doctrine")
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter('id', $step_id)
            ->getResult();


        return $this->redirectToRoute('projectView', array(
               'id' => $project_id,
        ));

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
        ];
    }

    /**
     * @Template()
     * @Route("/project/{id}/participate", name="projectParticipate")
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
           ->getRepository("AppBundle:Contributor")
           ->findBy([
               'user' => $user,
               'project' => $project
           ]) ?: false;

        $message = null;

        return [
            'id'            => $id,
            'message'       => $message,
            'isParticipant' => $isParticipant,
            'imInButton'    => $imInButton,
        ];
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
