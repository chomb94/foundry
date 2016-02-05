<?php

namespace AppBundle\Services;

use AppBundle\Base\BaseService;
use AppBundle\Entity\UserGoogle;

class Mail extends BaseService
{
    public function send($users, $subject, $template, array $params = array())
    {
        if ($users instanceof UserGoogle) {
            $users = array($users);
        }

        $message = \Swift_Message::newInstance()
           ->setSubject($subject)
           ->setFrom($this->getParameter('mailer_from'))
        ;

        foreach ($users as $user) {
            $message
                ->setTo($user->getEmail())
                ->setBody(
                   $this->get('templating')->render($template, array_merge($params, [
                       'user'    => $user,
                       'subject' => $subject,
                   ])),
                   'text/html'
                )
            ;
            $this->get('mailer')->send($message);
        }

        return $message;
    }
}

