<?php

namespace Tests\Traits;

use AppBundle\Entity\Action;
use AppBundle\Entity\Terrain;
use AppBundle\Entity\User;

trait ActionTrait
{

    /**
     * @param User $user
     * @param Terrain $terrain
     * @return Action
     */
    public function newAction(User $user, Terrain $terrain)
    {
        $action = new Action();
        $action->setUser($user);
        $action->setTerrain($terrain);

        return $action;
    }

    /**
     * @param User $user
     * @param Terrain $terrain
     * @return Action
     */
    protected function newActionPersistent(User $user, Terrain $terrain)
    {
        $action = $this->newAction($user, $terrain);

        $this->em->persist($action);
        $this->em->flush($action);

        return $action;
    }
}