<?php

namespace AppBundle\Service;

use AppBundle\Entity\Action;
use AppBundle\Entity\Mob;
use Tests\AppBundle\AbstractTestCase;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Tests\Traits\ActionTrait;
use Tests\Traits\CharacterTrait;
use Tests\Traits\MobTrait;
use Tests\Traits\UserTrait;

class GameServiceTest extends AbstractTestCase
{
    use UserTrait;
    use CharacterTrait;
    use ActionTrait;
    use MobTrait;

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testGenerateTerrain()
    {
        $gameService = $this->getContainer()->get('app_game.service');

        // Populate
        $gameService->newGame();

        $terrain = $this->em->getRepository('AppBundle:Terrain')->findBy([
            'x' => 1,
            'y' => 1,
        ]);

        // Validate
        $this->assertNotEmpty($terrain);

        // Populate
        $gameService->resetGame();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testAttack()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );
        $character = $this->newCharacterPersistent(
            $user,
            $this->faker->name
        );
        $mob = $this->newMobPersistent();

        $action = $this->getContainer()
            ->get('app_game.service')
            ->attack($user, $mob);


        $this->removeEntity($action);
        $this->removeEntity($mob);
        $this->removeEntity($character);
        $this->removeEntity($user);
    }
}
