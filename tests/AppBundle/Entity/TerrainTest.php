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
        $terrain = $this->newTerrainPersistent(
            $this->faker->randomNumber(1, 9999999),
            $this->faker->randomNumber(1, 9999999),
            $mob
        );

        $this->assertNotEmpty($terrain->getId());

        $this->removeEntity($terrain);
    }
}
