<?php

namespace AppBundle\Service;

use AppBundle\Game\GameStatus;
use AppBundle\Entity\Mob;
use AppBundle\Entity\Terrain;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Action;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

class GameService
{
    const EXPERIENCE_MULTIPLIER = 10;

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
     * @param Action $action
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addExperienceToCharacter(Action $action)
    {
        $character = $action->getUser()->getCharacter();
        $mob = $action->getMob();

        $character->setExperience($this->getExperienceFromMob($mob));
        $mob->setIsKilled(true);

        $this->em->persist($character);
        $this->em->persist($mob);
        $this->em->flush([
            $character,
            $mob
        ]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function newGame()
    {
        $this->deleteGameHistory();

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
        // todo: finish this part

        return new GameStatus(
            $user->getCharacter()->getExperience(),
            0,
            0,
            0,
            true
        );
    }

    public function deleteGameHistory()
    {
        $this->em->createQuery('DELETE AppBundle:Terrain t')->execute();
        $this->em->createQuery('DELETE AppBundle:Mob m')->execute();
        $this->em->createQuery('DELETE AppBundle:Action a')->execute();
        $this->em->createQuery('DELETE AppBundle:Character c')->execute();
    }

    /**
     * @param Mob $mob
     * @return int
     */
    private function getExperienceFromMob(Mob $mob): int
    {
        return $mob->getType()
            * rand(1, 9)
            * self::EXPERIENCE_MULTIPLIER;
    }

}
