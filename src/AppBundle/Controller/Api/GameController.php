<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class GameController extends ApiControllerTemplate
{
    /**
     * @return Response
     */
    final public function statusAction(): Response
    {
        $progress = $this
            ->get('app_game.service')
            ->getStatus($this->getUser());

        return new Response(
            $this->serializeObject($progress)
        );
    }

    /**
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function newAction(): Response
    {
        $this
            ->get('app_game.service')
            ->newGame();

        return new Response();
    }


}
