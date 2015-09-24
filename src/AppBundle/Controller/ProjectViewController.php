<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ProjectType;

class ProjectViewController extends Controller
{
    /**
     * @Route("/project/view/{id}")
     */
    public function projectView(Request $request,  $id)
    {
        $project = $this->get("doctrine")->getRepository("AppBundle:Project")->find($id);
        $user = $this->getUser();
        $user_id = $user->getId();
        $myproject = ($user_id == $project->getUserId());
        $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $id]);
        $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $project]);
        

        return $this->render('default/projectView.html.twig', [
            'project' => $project,
            'project_id' => $id,
            'myproject' => $myproject,
            'steps' => $step_list,
            'error' => $request->get("error", 0),
        ]); 
    }
}
