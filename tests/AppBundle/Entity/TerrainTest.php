<?php

namespace Test\AppBundle\Entity;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\TerrainTrait;

class TerrainTest extends AbstractTestCase
{
    use TerrainTrait;

    public function testMobPersist()
    {
        $mob = $this->newMob();
        $terrain = $this->newTerrainPersistent($mob);

        $this->assertNotEmpty($terrain->getId());

        $this->removeEntity($terrain);
    }

}