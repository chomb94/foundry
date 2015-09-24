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
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findAll();
        
        // replace this example code with whatever you need
        return $this->render('default/userProjectList.html.twig', array(
            //'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'menu_myprojects' => 'active',
            'projects' => $projects,
            'user' => $user,
        ));
    }
}
