<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class UserPersistenceListener
{
    /**
     * @var EncoderFactory
     */
    protected $encoder;

    /**
     * @param EncoderFactory $encoder
     */
    public function __construct(EncoderFactory $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifeCycleEventArgs $args)
    {
        $this->setPassword($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifeCycleEventArgs $args)
    {
        $this->setPassword($args);
        $this->setRole($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function setPassword(LifeCycleEventArgs $args)
    {
        /** @var User $object */
        $object = $args->getEntity();

        if ($object instanceof AdvancedUserInterface) {
            $encodedPassword = $this
                ->encoder
                ->getEncoder($object)
                ->encodePassword(
                    $object->getPlainPassword(),
                    $object->getSalt()
                );

            $object->setPassword($encodedPassword);
            $object->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function setRole(LifeCycleEventArgs $args)
    {
        /** @var User $object */
        $object = $args->getEntity();

        if ($object instanceof AdvancedUserInterface) {
            $object->setRoles(User::ROLE_USER);
        }
    }
}
