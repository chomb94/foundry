<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/user/profile")
     */
    public function userMainAction()
    {
        $user = $this->getUser();
        $userCredits = $this->get("doctrine")->getRepository("AppBundle:UserCredits")->find($user->getId());
        
        // replace this example code with whatever you need
        return $this->render('default/user.html.twig', array(
            'menu_myprofile' => 'active',
            'user' => $user,
            'credits' => $userCredits,
        ));
    }
}
