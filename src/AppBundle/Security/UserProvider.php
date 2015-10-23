<?php

namespace AppBundle\Security;

use AppBundle\Entity\UserGoogle;
use AppBundle\Entity\UserCredits;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider extends EntityUserProvider
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch (UsernameNotFoundException $e) {
            // User not found, let's register them.
            $user = new UserGoogle();
            $user->setEmail($response->getEmail());
            $user->setGoogleId($response->getUsername());
            $user->setUsername($response->getEmail());
            $user->setProfilePicture($response->getProfilePicture());
            $user->setNickname($response->getNickname());

            $this->em->persist($user);
            $this->em->flush();

            $userCredits = new UserCredits();
            $userCredits->setUserId($user->getId());
            $userCredits->setCredits(5);

            $this->em->persist($userCredits);
            $this->em->flush();

            return $user;
        }
    }
}
