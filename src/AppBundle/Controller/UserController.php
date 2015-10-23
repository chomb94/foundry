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
        $userCredits = $this->get("doctrine")->getRepository("AppBundle:UserCredits")->findBy(array('user_id' => $user->getId()))[0];

        $projectsPledged = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(array('user_id' => $user->getId()));

        // replace this example code with whatever you need
        return $this->render('default/user.html.twig', array(
            'menu_myprofile' => 'active',
            'user' => $user,
            'userCredits' => $userCredits,
            'projectsPledged' => $projectsPledged,
        ));
    }
}
