<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\StepType;

class UserStepsEditController extends Controller
{
    /**
     * @Route("/user/step/{id}/edit")
     */
    public function stepEditAction(Request $request, $id)
    {
        $step_init = $this->get("doctrine")->getRepository("AppBundle:Step")->find($id);
        $user = $this->getUser();
        $form = $this->createForm(new StepType(), $step_init);
        $form->handleRequest($request);
        $step = $form->getData();
        $project_id = $step_init->getProjectId();
        $project = $this->get("doctrine")->getRepository("AppBundle:Project")->find($project_id);


        if ($form->isValid()) {
          // perform some action, such as saving the task to the database
          // Store in DB
          $step->setCreationDate(new \DateTime());
          $step->setProjectId($project_id);
          $manager = $this->get("doctrine")->getManager();
          $manager->persist($step);
          $manager->flush();
        }

        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $project_id]);

        return $this->render('default/stepsPublish.html.twig', [
            'form' => $form->createView(),
            'project_title' => $project->getTitle(),
            'project_id' => $project->getId(),
            'steps' => $step_list,
            'user' => $user,
            'menu_myprojects' => 'active',
        ]);
    }
}
  