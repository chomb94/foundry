<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\ProjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProjectPublishController extends Controller
{
    /**
     * @Route("/user/project/publish")
     */
    public function userProjectPublish(Request $request)
    {
        $form = $this->createForm(new ProjectType());
        $form->handleRequest($request);
        $project = $form->getData();

        if ($form->isValid()) {
          var_dump($form->getData());
           // perform some action, such as saving the task to the database
           // Store in DB
           $project->setCreationDate(new \DateTime());
           $manager = $this->get("doctrine")->getManager();
           $manager->persist($project);
           $manager->flush();
           return $this->redirectToRoute('app_lucky_number');
        }

        return $this->render('default/projectPublish.html.twig', [
            'form' => $form->createView(),
            'menu_start' => 'active',
        ]);
        
       
    }
}
