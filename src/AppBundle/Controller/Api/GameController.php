<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class GameController extends Controller
{
    /**
     * @return Response
     */
    final public function progressAction(): Response
    {
        $progress = $this
            ->get('app_game.service')
            ->getProgress($this->getUser());

        return new Response($progress);
    }

    /**
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @return Response
     */
    final public function newAction(): Response
    {
        $this
            ->get('app_game.service')
            ->newGame();

        return new Response();
    }

}
