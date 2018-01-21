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
        $action = new Character();
        $action->setUser($user);
        $action->setName($name);

        return $action;
    }

    /**
     * @param User $user
     * @param string $name
     * @return Character
     */
    protected function newCharacterPersistent(User $user, $name)
    {
        $action = $this->newCharacter($user, $name);

        $this->em->persist($action);
        $this->em->flush($action);

        return $action;
    }
}