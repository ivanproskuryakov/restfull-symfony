<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use LogicException;

use AppBundle\Game\GameStatus;
use AppBundle\Entity\Mob;
use AppBundle\Entity\Terrain;
use AppBundle\Entity\User;
use AppBundle\Entity\Action;

class GameService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param User $user
     * @param Mob $mob
     * @throws ORMException
     * @throws OptimisticLockException
     * @return Action
     */
    public function attack(User $user, Mob $mob): Action
    {
        $character = $this
            ->em
            ->getRepository('AppBundle:Character')
            ->findOneBy([
                'user' => $user->getId()
            ]);
        $character->setExperience($mob->getExperience());

        $action = new Action();
        $action->setUser($user);
        $action->setMob($mob);
        $action->setType(Action::ACTION_TYPE_ATTACK);

        $mob = $action->getMob();
        $mob->setIsKilled(true);

        $this->em->persist($action);
        $this->em->persist($character);
        $this->em->persist($mob);
        $this->em->flush([
            $action,
            $character,
            $mob
        ]);

        return $action;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function newGame()
    {
        $this->resetGame();

        for ($x = 0; $x < Terrain::SIZE_X; $x++) {
            for ($y = 0; $y < Terrain::SIZE_Y; $y++) {
                $type = Mob::getRandomType();

                $mob = new Mob($type);
                $terrain = new Terrain($x, $y, $mob);

                $this->em->persist($terrain);
            }
        }

        $this->em->flush();
    }

    /**
     * @param User $user
     * @return GameStatus
     */
    public function getStatus(User $user): GameStatus
    {
        $character = $this
            ->em
            ->getRepository('AppBundle:Character')
            ->findOneBy([
                'user' => $user->getId()
            ]);

        if (!$character) {
            throw new LogicException('You need to have a character to play the game.');
        }

        // todo: is missing ...
        return new GameStatus(
            $character->getExperience(),
            0,
            0,
            0,
            true
        );
    }

    public function resetGame()
    {
        //todo: to be improved ...

        $this->em->createQuery('DELETE AppBundle:Terrain t')->execute();
        $this->em->createQuery('DELETE AppBundle:Action a')->execute();
        $this->em->createQuery('DELETE AppBundle:Mob m')->execute();
        $this->em->createQuery('DELETE AppBundle:Character c')->execute();
    }
}
