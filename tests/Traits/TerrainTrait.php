<?php

namespace Tests\Traits;

use AppBundle\Entity\Terrain;
use AppBundle\Entity\Mob;

trait TerrainTrait
{
    /**
     * @param integer $x
     * @param integer $y
     * @param Mob $mob
     * @return Terrain
     */
    protected function newTerrain($x, $y, Mob $mob)
    {
        $user = new Terrain($x, $y, $mob);

        return $user;
    }

    /**
     * @param integer $x
     * @param integer $y
     * @param Mob $mob
     * @return Terrain
     */
    protected function newTerrainPersistent($x, $y, Mob $mob)
    {
        $terrain = $this->newTerrain($x, $y, $mob);

        $this->em->persist($terrain);
        $this->em->flush($terrain);

        return $terrain;
    }
}