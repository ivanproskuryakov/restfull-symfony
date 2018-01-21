<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;
use Tests\Traits\TerrainTrait;

class TerrainControllerTest extends AbstractWebTestCase
{
    use MobTrait;
    use TerrainTrait;

    public function testGetActionSuccess()
    {
        $mob = $this->newMob();
        $terrain = $this->newTerrainPersistent(
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $mob
        );

        $this->assertNotEmpty($terrain->getId());

        $this->removeEntity($terrain);

    }

}