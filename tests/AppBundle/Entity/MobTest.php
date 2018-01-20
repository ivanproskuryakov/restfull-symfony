<?php

namespace Test\AppBundle\Entity\Social\Integration;

use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\MobTrait;

class MobTest extends AbstractTestCase
{
    use MobTrait;

    public function testMobPersist()
    {
        $mob = $this->newMobPersistent();

        $this->assertNotEmpty($mob->getId());

        $this->removeEntity($mob);
    }


}