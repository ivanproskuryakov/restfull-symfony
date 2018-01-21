<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Entity\User;

class UserService implements UserProviderInterface
{
    /**
     * @var EncoderFactory
     */
    private $encoder;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param Session $session
     * @param EntityManager $entityManager
     * @param EncoderFactory $encoder
     * @param TokenStorage $tokenStorage
     */
    public function __construct(
        Session $session,
        EntityManager $entityManager,
        EncoderFactory $encoder,
        TokenStorage $tokenStorage
    ) {
        $this->session = $session;
        $this->encoder = $encoder;
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param $email string
     * @param $password string
     * @throws UnprocessableEntityHttpException
     */
    public function login(string $email,string  $password)
    {
        $user = $this->loadUserByEmail($email);

        if (false === ($user instanceof User)) {
            throw new UnprocessableEntityHttpException('A user with such Email doesn\'t exists');
        }

        if (false === $this->checkUserPassword($user, $password)) {
            throw new UnprocessableEntityHttpException('The credentials are wrong');
        }

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set('_security_main', serialize($token));
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function loadUserByUsername($username)
    {
        return $this->loadUserByEmail($username);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function loadUserByEmail(string $email)
    {
        return $this->em
            ->getRepository('AppBundle:User')
            ->findOneBy([
                'email' => $email,
                'enabled' => true
            ]);
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }
        $user = $this
            ->em
            ->getRepository(User::class)
            ->find($user->getId());


        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        $name = 'AppBundle\Entity\User';

        return $name === $class || is_subclass_of($class, $name);
    }

    /**
     * @param User $user
     * @param string $password
     * @return boolean $isValid
     */
    private function checkUserPassword(User $user, string $password)
    {
        return $this->encoder
            ->getEncoder($user)
            ->isPasswordValid(
                $user->getPassword(),
                $password,
                $user->getSalt()
            );
    }
}
