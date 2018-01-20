<?php

namespace Test\AppBundle\Entity;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\MobTrait;
use Tests\Traits\TerrainTrait;
use Tests\Traits\ActionTrait;
use Tests\Traits\UserTrait;

class ActionTest extends AbstractTestCase
{
    use ActionTrait;
    use UserTrait;
    use MobTrait;
    use TerrainTrait;

    public function testMobPersist()
    {
        $mob = $this->newMob();
        $terrain = $this->newTerrainPersistent($mob);
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );

        $action = $this->newActionPersistent($user, $terrain);

        $this->assertNotEmpty($action->getId());

        $this->removeEntity($action);
        $this->removeEntity($terrain);
        $this->removeEntity($user);
    }


}