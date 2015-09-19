<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\ProjectType;
use Symfony\Component\HttpFoundation\Request;
		

class LoginCheckGoogle extends Controller
{
    /**
     * @Route("/login/check-google")
     */
    public function numberAction(Request $request)
    {


        return $this->render('default/LoginCheckGoogle.html.twig', [

        ]);
        
       
    }
}
