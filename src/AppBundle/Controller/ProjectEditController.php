<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Entity\CreditsHistory;

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
        $user = $this->getUser();

        if ($form->isValid()) {
          $user_id = $user->getId();

           // perform some action, such as saving the task to the database
           // Store in DB
           $project->setCreationDate(new \DateTime());
           $project->setUser($user);
           $manager = $this->get("doctrine")->getManager();
           $manager->persist($project);
           $manager->flush();
           return $this->redirectToRoute('app_projectview_projectview', ['id' => $project->getId(), 'user' => $user]);
        }

        return $this->render('default/projectPublish.html.twig', [
            'form' => $form->createView(),
            'menu_start' => 'active',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/project/{id}/pledge")
     */
    public function projectPledge(Request $request, $id)
    {
        $user = $this->getUser();
        $user_id = $user->getId();
        $project = $this->getDoctrine()->getRepository("AppBundle:Project")->find($id);
        $user_credits = $this->getDoctrine()->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user_id])[0];

        if ($user_credits->getCredits() - $request->get("price") < 0) {
          return $this->redirectToRoute(
            'app_projectview_projectview',
            ['id'=>$project->getId(), 'error' => 1]);
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

        return $this->redirectToRoute('app_projectview_projectview', ['id'=>$project->getId(), 'user'=>$user]);
    }
}
