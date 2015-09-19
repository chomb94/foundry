<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\ProjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction(Request $request)
    {
        $number = rand(0, 100);
        
        $form = $this->createForm(new ProjectType());
        $form->handleRequest($request);
        $project = $form->getData();

        if ($form->isValid()) {
           // perform some action, such as saving the task to the database
           // Store in DB
           $project->setCreationDate(new \DateTime());
           $manager = $this->get("doctrine")->getManager();
           $manager->persist($project);
           $manager->flush();
           return $this->redirectToRoute('app_lucky_number');
        }

        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findAll();

        return $this->render('default/jmc.html.twig', [
            'number' => $number,
            'projects' => $projects,
            'form' => $form->createView(),
        ]);
        
       
    }
}
