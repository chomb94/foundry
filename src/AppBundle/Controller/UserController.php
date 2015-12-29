<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Base\BaseController;

class UserController extends BaseController
{
    /**
     * @Route("/user/profile", name="userIndex")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function indexAction()
    {
        $user        = $this->getUser();
        $userCredits = $this
              ->get("doctrine")
              ->getRepository("AppBundle:UserCredits")
              ->findBy(array('user_id' => $user->getId()))[0]
        ;

        $projectsPledged = $this
           ->get("doctrine")
           ->getRepository("AppBundle:CreditsHistory")
           ->findBy(array('user_id' => $user->getId()))
        ;

        return [
            'menu_myprofile'  => 'active',
            'user'            => $user,
            'userCredits'     => $userCredits,
            'projectsPledged' => $projectsPledged,
        ];
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function myCreditsAction()
    {
        $user        = $this->getUser();
        $userCredits = $this
              ->get("doctrine")
              ->getRepository("AppBundle:UserCredits")
              ->findBy(array('user_id' => $user->getId()))[0]
        ;
        return [
            'credits' => $userCredits->getCredits(),
        ];
    }
}
