<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\ProjectType;

class UserProjectListController extends Controller
{
    /**
     * @Route("/user/project/list")
     */
    public function userProjectList()
    {
        $user = $this->getUser();
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findBy(array('user_id' => $user->getId()));

        foreach ($projects as $oneProject) {
            $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $oneProject->getId()]);
            $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $oneProject]);
            $oneProject->setStepsAndCredits($step_list, $all_credits);
        }


        // replace this example code with whatever you need
        return $this->render('default/userProjectList.html.twig', array(
            'menu_myprojects' => 'active',
            'projects' => $projects,
            'user' => $user,
        ));
    }
}
