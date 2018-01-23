<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Action;
use AppBundle\Entity\Mob;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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


    /**
     * @param Mob $mob
     * @param string $type
     * @ParamConverter("mob", class="AppBundle\Entity\Mob")
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function attackAction(Mob $mob, string $type): Response
    {
        switch (true) {
            case $type == Action::ACTION_TYPE_ATTACK;
                $this
                    ->get('app_game.service')
                    ->attack(
                        $this->getUser(),
                        $mob
                    );
                break;
            case $type == Action::ACTION_TYPE_DEFEND;
                // todo: ...
                break;
            case $type == Action::ACTION_TYPE_RUN;
                // todo: ...
                break;
        }

        return new Response();
    }


}
