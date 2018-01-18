<?php

namespace Test\AppBundle\Entity\Social\Integration;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\UserTrait;

class UserTest extends AbstractTestCase
{
    use UserTrait;

    public function testUserPersist()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );

        $this->assertNotEmpty($user->getId());

        $this->removeEntity($user);
    }


}