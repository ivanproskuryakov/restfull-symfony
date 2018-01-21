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

    public function testActionPersist()
    {
        $mob = $this->newMobPersistent();
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );

        $action = $this->newActionPersistent($user, $mob);

        $this->assertNotEmpty($action->getId());

        $this->removeEntity($action);
        $this->removeEntity($mob);
        $this->removeEntity($user);
    }
}
