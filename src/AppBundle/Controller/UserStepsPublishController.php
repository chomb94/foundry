<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Form\Type\StepType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserStepsPublishController extends Controller
{
    /**
     * @Route("/user/steps/publish")
     */
    public function userProjectPublish(Request $request)
    {
        $form = $this->createForm(new ProjectType());
        $form->handleRequest($request);
        $project = $form->getData();

        if ($form->isValid()) {
          $user = $this->getUser();
          var_dump($user->getId());die();
           // perform some action, such as saving the task to the database
           // Store in DB
           $project->setCreationDate(new \DateTime());
           $manager = $this->get("doctrine")->getManager();
           $manager->persist($project);
           $manager->flush();
           return $this->redirectToRoute('app_steps_publication');
        }

        return $this->render('default/projectPublish.html.twig', [
            'form' => $form->createView(),
            'menu_start' => 'active',
        ]);
        
       
    }
}
