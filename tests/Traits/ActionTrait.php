<?php

namespace Tests\Traits;

use AppBundle\Entity\Action;
use AppBundle\Entity\Mob;
use AppBundle\Entity\User;

trait ActionTrait
{

    /**
     * @param User $user
     * @param Mob $mob
     * @return Action
     */
    public function newAction(User $user, Mob $mob)
    {
        $action = new Action();
        $action->setType($this->faker->numberBetween(1, 9999999));
        $action->setUser($user);
        $action->setMob($mob);

        return $action;
    }

    /**
     * @param User $user
     * @param Mob $mob
     * @return Action
     */
    protected function newActionPersistent(User $user, Mob $mob)
    {
        $action = $this->newAction($user, $mob);

        $this->em->persist($action);
        $this->em->flush($action);

        return $action;
    }
}
