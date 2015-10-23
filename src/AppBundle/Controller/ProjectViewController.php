<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;
use AppBundle\Entity\UserCredits;

class ProjectViewController extends Controller
{
    /**
     * @Route("/project/view/{id}")
     */
    public function projectView(Request $request,  $id)
    {
        $project = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $user = $this->getUser();
        $user_id = ($user != null ? $user->getId() : 0);
        $myproject = ($user_id == $project->getUser()->getId());
        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $id]);
        $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $project]);
        
        $user_credits = null;
        if ($user_id != 0) {
            $user_credits = $this->get("doctrine")->getRepository("AppBundle:UserCredits")->findBy(['user_id' => $user_id])[0];
        } else {
            $user_credits = new UserCredits();
            $user_credits->setCredits(100);
        }
        
        $project->setStepsAndCredits($step_list, $all_credits);

        return $this->render('default/projectView.html.twig', [
            'project' => $project,
            'project_id' => $id,
            'myproject' => $myproject,
            'userCredits' => $user_credits,
            'steps' => $project->getSteps(),
            'error' => $request->get("error", 0),
            'user' => $user,
        ]); 
    }
}
