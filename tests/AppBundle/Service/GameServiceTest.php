<?php

namespace AppBundle\Service;

use Tests\AppBundle\AbstractTestCase;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class GameServiceTest extends AbstractTestCase
{

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testGenerateTerrainSuccess()
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
}
