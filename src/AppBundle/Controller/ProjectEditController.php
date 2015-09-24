<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;

class ProjectEditController extends Controller
{
    /**
     * @Route("/user/project/{id}/edit")
     */
    public function projectEdit(Request $request, $id)
    {
        $project_init = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $form = $this->createForm(new ProjectType(), $project_init);
        $form->handleRequest($request);
        $project = $form->getData();

        if ($form->isValid()) {
          $user = $this->getUser();
          $user_id = $user->getId();

           // perform some action, such as saving the task to the database
           // Store in DB
           $project->setCreationDate(new \DateTime());
           $project->setUserId($user_id);
           $manager = $this->get("doctrine")->getManager();
           $manager->persist($project);
           $manager->flush();
           return $this->redirectToRoute('app_projectview_projectview', ['id'=>$project->getId()]);
        }

        return $this->render('default/projectPublish.html.twig', [
            'form' => $form->createView(),
            'menu_start' => 'active',
        ]);

    }
}
