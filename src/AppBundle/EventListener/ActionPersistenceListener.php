<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

use AppBundle\Entity\Action;
use AppBundle\Service\GameService;

class ActionPersistenceListener
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * @param GameService $gameService
     */
    public function __construct(GameService $gameService) {
        $this->gameService = $gameService;
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function postPersist(LifeCycleEventArgs $args)
    {
        /** @var Action $action */
        $action = $args->getEntity();

        if ($action instanceof Action) {
            $this->gameService->addExperienceToCharacter($action);
        }
    }

}
