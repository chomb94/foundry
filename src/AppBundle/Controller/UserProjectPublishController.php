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
        $user = $this->getUser();

        if ($form->isValid()) {
          $user_id = $user->getId();

          // perform some action, such as saving the task to the database
          // Store in DB
          $project->setCreationDate(new \DateTime());
          $project->setUserId($user_id);
          $manager = $this->get("doctrine")->getManager();
          $manager->persist($project);
          $manager->flush();
          return $this->redirectToRoute('app_usersteps_publish', ['id' => $project->getId(), 'user' => $user]);
        }

        return $this->render('default/projectPublish.html.twig', [
            'form' => $form->createView(),
            'menu_start' => 'active',
            'user' => $user,
        ]);       
    }
}
