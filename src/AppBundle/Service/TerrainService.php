<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Mob;
use AppBundle\Entity\Terrain;

class TerrainService
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

    public function generateTerrain()
    {
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

}