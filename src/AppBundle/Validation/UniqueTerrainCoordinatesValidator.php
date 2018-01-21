<?php

namespace AppBundle\Validation;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use AppBundle\Entity\Terrain;

class UniqueTerrainCoordinatesValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManage
     */
    public function __construct(EntityManager $entityManage)
    {
        $this->em = $entityManage;
    }

    /**
     * @param Terrain $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        $terrain = $this
            ->em
            ->getRepository(Terrain::class)
            ->findOneBy([
                'x' => $value->getX(),
                'y' => $value->getY(),
            ]);


        if ($terrain) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
