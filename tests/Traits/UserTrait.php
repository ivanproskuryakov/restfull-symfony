<?php

namespace Tests\Traits;

use Faker;
use AppBundle\Entity\User;

trait UserTrait
{

    /**
     * @return User
     */
    public function newUser()
    {
        $faker = $this->getFaker();

        $user = new User();
        $user->setUsername($faker->userName);
        $user->setEmail($faker->email);
        $user->setPlainPassword($faker->password);
        $user->setEnabled(true);

        return $user;
    }

    /**
     * @return User
     */
    protected function newUserPersistent()
    {
        $user = $this->newUser();

        $this->em->persist($user);
        $this->em->flush($user);

        return $user;
    }

    /**
     * @return Faker\Generator
     */
    abstract protected function getFaker();
}