<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use LogicException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class GameController extends Controller
{
//    /**
//     * @return Response
//     */
//    final public function statusAction(): Response
//    {
//        if (null === $this->getUser()->getCharacter()) {
//            throw new LogicException('Create character first');
//        }
//
//        $progress = $this
//            ->get('app_game.service')
//            ->getStatus($this->getUser());
//
//        return new Response($progress);
//    }

    /**
     * @return Response
     * @throws LogicException
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
