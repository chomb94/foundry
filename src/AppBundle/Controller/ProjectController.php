<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Form\Type\StepType;
use AppBundle\Entity\CreditsHistory;
use AppBundle\Entity\UserCredits;

class ProjectController extends Controller
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
        $user_id     = ($user != null ? $user->getId() : 0);
        $myproject   = ($user_id == $project->getUser()->getId());
        $step_list   = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $id]);
        $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $project]);

        $user_credits = null;
        if ($user_id != 0) {
            $user_credits = $this->get("doctrine")->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user_id])[0];
        } else {
            $user_credits = new UserCredits();
            $user_credits->setCredits(100);
        }

        $project->setStepsAndCredits($step_list, $all_credits);

        return [
            'project'     => $project,
            'project_id'  => $id,
            'myproject'   => $myproject,
            'userCredits' => $user_credits,
            'steps'       => $project->getSteps(),
            'error'       => $request->get("error", 0),
            'user'        => $user,
        ];
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

        if ($user_credits->getCredits() - $request->get("price") < 0) {
            return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'error' => 1]);
        }

        $creditHistory = new CreditsHistory();
        $creditHistory->setUserId($user_id);
        $creditHistory->setProject($project);
        $creditHistory->setNbCreditsSpent($request->get("price"));
        $creditHistory->setPledgeDate(date_create("now"));

        $user_credits->setCredits($user_credits->getCredits() - $request->get("price"));

        $em = $this->getDoctrine()->getManager();
        $em->persist($creditHistory);
        $em->persist($user_credits);
        $em->flush();

        return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'user' => $user]);
    }

    /**
     * @Route("/project/list", name="projectList')
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
        $form->handleRequest($request);
        $project = $form->getData();

        if ($form->isValid()) {
            $project->setCreationDate(new \DateTime());
            $project->setUser($user);
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute('projectView', ['id' => $project->getId(), 'user' => $user]);
        }

        return [
            'form'       => $form->createView(),
            'menu_start' => 'active',
            'user'       => $user,
        ];
    }

    /**
     * @Route("/project/publish", name="projectPublish')
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function publishAction(Request $request)
    {
        $form    = $this->createForm(new ProjectType());
        $form->handleRequest($request);
        $project = $form->getData();
        $user    = $this->getUser();

        if ($form->isValid()) {
            $project->setCreationDate(new \DateTime());
            $project->setUser($user);
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute('projectStepPublish', ['id' => $project->getId(), 'user' => $user]);
        }

        return [
            'form'       => $form->createView(),
            'menu_start' => 'active',
            'user'       => $user,
        ];
    }

    /**
     * @Route("/project/step/{id}/edit", name="projectStepEdit')
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
        }

        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $project_id]);

        return [
            'form'            => $form->createView(),
            'project_title'   => $project->getTitle(),
            'project_id'      => $project->getId(),
            'steps'           => $step_list,
            'user'            => $user,
            'menu_myprojects' => 'active',
        ];
    }

    /**
     * @Route("/user/project/{id}/steps/publish", name="projectStepPublish')
     * @Security("has_role('ROLE_USER')")
     * @Template("AppBundle:Project:step.html.twig")
     */
    public function publishStepAction($id, Request $request)
    {
        $project    = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $project_id = $project->getId();
        $user       = $this->getUser();
        $user_id    = $user->getId();

        if ($project->getUser()->getId() <> $user_id) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(new StepType());
        $form->handleRequest($request);
        $step = $form->getData();

        if ($form->isValid()) {
            $step->setCreationDate(new \DateTime());
            $step->setProjectId($project->getId());
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($step);
            $manager->flush();
        }

        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $project_id]);

        return [
            'form'            => $form->createView(),
            'project_title'   => $project->getTitle(),
            'project_id'      => $project->getId(),
            'steps'           => $step_list,
            'menu_myprojects' => 'active',
            'user'            => $user,
        ];
    }

}
