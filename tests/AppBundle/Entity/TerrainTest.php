<?php

namespace Test\AppBundle\Entity\Social\Integration;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\TerrainTrait;

class TerrainTest extends AbstractTestCase
{
    use TerrainTrait;

    public function testMobPersist()
    {
        $terrain = $this->newTerrainPersistent();

        $this->assertNotEmpty($terrain->getId());

        $this->removeEntity($terrain);
    }

}