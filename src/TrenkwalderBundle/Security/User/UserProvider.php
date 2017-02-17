<?php

namespace TrenkwalderBundle\Security\User;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use TrenkwalderBundle\Entity\User;


class UserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface {

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var \TrenkwalderBundle\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * UserProvider constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->userRepository = $this->em->getRepository('TrenkwalderBundle:User');
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username) {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $userResponse) {

        $user = null;

        $response = $userResponse->getResponse();

        if(!empty($response) && !empty($response['user_id'])) {
            $user = $this->userRepository->findOneBy(['auth0Id' => $response['user_id']]);

            if(empty($user)) {
                $user = new User($response['user_id']);

                if(array_key_exists('given_name', $response))
                    $user->setFirstName($response['given_name']);
                if(array_key_exists('family_name', $response))
                    $user->setLastName($response['family_name']);
                if(array_key_exists('locale', $response))
                    $user->setLocale($response['locale']);

            }

            $user->setEmail($response['email']);
            $user->setEmailVerified($response['email_verified']);

            // TODO-IB: save picture local, because of limit of external resources, e.g. google profile images
            $user->setPicture($response['picture']);

            $this->em->persist($user);
            $this->em->flush();

        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {

        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        return $this->findUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === 'TrenkwalderBundle\\Entity\\User';
    }

    private function findUser(User $user) {

        if(empty($user->getId())) {
            return null;
        }

        return $this->userRepository->find($user->getId());
    }
}
