<?php

namespace AppBundle\Services;

use AppBundle\Base\BaseService;
use AppBundle\Entity\UserGoogle;

class Mail extends BaseService
{

    public function send(UserGoogle $user, $subject, $template, array $params = array())
    {
        
    }


}

