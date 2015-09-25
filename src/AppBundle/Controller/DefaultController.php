<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    	$user = $this->getUser();
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findAll();

        foreach ($projects as $oneProject) {
            $step_list = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $oneProject->getId()]);
            $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $oneProject]);
            $oneProject->setStepsAndCredits($step_list, $all_credits);
        }

        $randonum= rand(1,2);

        // replace this example code with whatever you need
        return $this->render('default/homepage.html.twig', array(
            //'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'menu_hp' => 'active',
            'projects' => $projects,
            'user' => $user,
            'backgroundImgNum' => $randonum,
        ));
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}

