<?php

namespace Test\AppBundle\Entity\Social\Integration;

use AppBundle\Entity\Action;
use Tests\AppBundle\AbstractTestCase;
use Tests\Traits\UserTrait;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class ActionTest extends AbstractTestCase
{
    use UserTrait;

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testChallengePersist()
    {
        $challenger = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );
        $challengeable = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );

        $challenge = new Challenge();
        $challenge->setChallenger($challenger);
        $challenge->setChallengeable($challengeable);
        $challenge->setStatus(Challenge::STATUS_STARTED);

        $this->em->persist($challenge);
        $this->em->flush($challenge);

        $this->removeEntity($challenge);
    }


}