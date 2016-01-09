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

        $projectsContributed = $this
           ->get("doctrine")
           ->getRepository("AppBundle:Contributor")
           ->findBy(array('user' => $user))
        ;

        return [
            'menu_myprofile'  => 'active',
            'user'            => $user,
            'projectsContributed' => $projectsContributed,
        ];
    }   
}
