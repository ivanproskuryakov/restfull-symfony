<?php

namespace Tests\Traits;

use AppBundle\Entity\Mob;

trait MobTrait
{

    /**
     * @return Mob
     */
    protected function newMob()
    {
        $type = Mob::getRandomType();

        $mob = new Mob($type);

        return $mob;
    }

    /**
     * @return Mob
     */
    protected function newMobPersistent()
    {
        $mob = $this->newMob();

        $this->em->persist($mob);
        $this->em->flush($mob);

        return $mob;
    }
}