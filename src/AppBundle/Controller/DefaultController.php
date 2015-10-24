<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
    	$user = $this->getUser();

        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findAll();

        foreach ($projects as $oneProject) {
            $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $oneProject->getId()]);
            $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $oneProject]);
            $oneProject->setStepsAndCredits($step_list, $all_credits);
        }

        return array(
            'menu_hp' => 'active',
            'projects' => $projects,
            'user' => $user,
        );
    }
}

