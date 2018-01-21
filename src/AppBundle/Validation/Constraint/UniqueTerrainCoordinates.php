<?php

namespace AppBundle\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueTerrainCoordinates extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The coordinates is in use';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return 'unique_terrain_coordinates';
    }

    public function getTargets(): string
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
