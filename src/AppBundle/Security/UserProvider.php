<?php

namespace AppBundle\Security;

use AppBundle\Entity\UserGoogle;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider extends EntityUserProvider {
	public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch (UsernameNotFoundException $e) {
            // User not found, let's register them.
            $user = new UserGoogle();
            $user->setEmail($response->getEmail());
            $user->setPassword('toto');
            $user->setGoogleId($response->getUsername());
            $user->setUsername($response->getEmail());

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }
    }
}