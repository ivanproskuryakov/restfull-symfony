<?php

namespace Test\AppBundle\Entity;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\TerrainTrait;
use Tests\Traits\MobTrait;

class TerrainTest extends AbstractTestCase
{
    use MobTrait;
    use TerrainTrait;

    public function testMobPersist()
    {
        $mob = $this->newMob();
        $terrain = $this->newTerrainPersistent($mob);

        $this->assertNotEmpty($terrain->getId());

        $this->removeEntity($terrain);
    }

}