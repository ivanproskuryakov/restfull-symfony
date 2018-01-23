<?php

namespace Tests\Traits;

use AppBundle\Entity\Character;
use AppBundle\Entity\User;

trait CharacterTrait
{

    /**
     * @param User $user
     * @param string $name
     * @return Character
     */
    public function newCharacter(User $user, $name)
    {
        $character = new Character();
        $character->setUser($user);
        $character->setName($name);

        return $character;
    }

    /**
     * @param User $user
     * @param string $name
     * @return Character
     */
    protected function newCharacterPersistent(User $user, $name)
    {
        $character = $this->newCharacter($user, $name);

        $this->em->persist($character);
        $this->em->flush($character);

        return $character;
    }
}
