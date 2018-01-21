<?php

namespace Test\AppBundle\Validation;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\TerrainTrait;
use Tests\Traits\MobTrait;

class TerrainTest extends AbstractTestCase
{
    use MobTrait;
    use TerrainTrait;

    public function testMobPersist()
    {
        $mobA = $this->newMob();
        $terrainA = $this->newTerrainPersistent(1, 1, $mobA);
        $terrainB = $this->newTerrain(1, 1, $mobA);

        $violations = $this->getContainer()->get('validator')->validate($terrainB);


        $this->assertEquals(
            'The coordinates is in use',
            $violations[0]->getMessage()
        );

        $this->removeEntity($terrainA);
    }

}