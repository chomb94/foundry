<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Form\Type\StepType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserStepsController extends Controller
{
    /**
     * @Route("/user/project/{id}/steps/publish")
     */
    public function Publish($id, Request $request)
    {

        $project = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $project_id = $project->getId();
        $user = $this->getUser();

        $form = $this->createForm(new StepType());
        $form->handleRequest($request);
        $step = $form->getData();

        if ($form->isValid()) {
          // perform some action, such as saving the task to the database
          // Store in DB
          $step->setCreationDate(new \DateTime());
          $step->setProjectId($project->getId());
          $manager = $this->get("doctrine")->getManager();
          $manager->persist($step);
          $manager->flush();
          //return $this->redirectToRoute('app_user_steps_publish');
        }

        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy( ['project_id' => $project_id]);

        return $this->render('default/stepsPublish.html.twig', [
            'form' => $form->createView(),
            'project_title' => $project->getTitle(),
            'project_id' => $project->getId(),
            'steps' => $step_list,
            'menu_myprojects' => 'active',
        ]);
        
       
    }
}
