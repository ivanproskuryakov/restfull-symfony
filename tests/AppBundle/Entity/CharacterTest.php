<?php

namespace Test\AppBundle\Entity;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\CharacterTrait;
use Tests\Traits\UserTrait;

class CharacterTest extends AbstractTestCase
{
    use CharacterTrait;
    use UserTrait;

    public function testCharacterPersist()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );

        $character = $this->newCharacterPersistent(
            $user,
            $this->faker->name
        );

        $this->assertNotEmpty($character->getId());

        $this->removeEntity($character);
        $this->removeEntity($user);
    }


}