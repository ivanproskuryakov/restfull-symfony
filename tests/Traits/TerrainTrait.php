<?php

namespace Tests\Traits;

use AppBundle\Entity\Terrain;
use AppBundle\Entity\Mob;

trait TerrainTrait
{
    /**
     * @param Mob $mob
     * @return Terrain
     */
    protected function newTerrain(Mob $mob)
    {
        $user = new Terrain(1,1, $mob);

        return $user;
    }

    /**
     * @param Mob $mob
     * @return Terrain
     */
    protected function newTerrainPersistent(Mob $mob)
    {
        $terrain = $this->newTerrain($mob);

        $this->em->persist($terrain);
        $this->em->flush($terrain);

        return $terrain;
    }
}