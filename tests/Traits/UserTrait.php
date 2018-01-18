<?php

namespace Tests\Traits;

use AppBundle\Entity\User;

trait UserTrait
{

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function newUser(string $email, string $password)
    {
        $user = new User();
        $user->setUsername($email);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    protected function newUserPersistent(string $email, string $password)
    {
        $user = $this->newUser($email, $password);

        $this->em->persist($user);
        $this->em->flush($user);

        return $user;
    }
}