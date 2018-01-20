<?php

namespace Tests\Traits;

use AppBundle\Entity\Terrain;

trait TerrainTrait
{
    use MobTrait;

    /**
     * @return Terrain
     */
    protected function newTerrain()
    {
        $user = new Terrain(1,1, $this->newMob());

        return $user;
    }

    /**
     * @return Terrain
     */
    protected function newTerrainPersistent()
    {
        $terrain = $this->newTerrain();

        $this->em->persist($terrain);
        $this->em->flush($terrain);

        return $terrain;
    }
}