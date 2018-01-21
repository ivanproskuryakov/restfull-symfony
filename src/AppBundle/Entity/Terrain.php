<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;
use DateTime;

use AppBundle\Entity\Traits\IdTrait;
use AppBundle\Entity\Traits\CreatedAtTrait;
use AppBundle\Entity\Traits\UpdateAtTrait;
use AppBundle\Validation\Constraint as AppValidation;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity()
 * @ORM\Table(
 *     name="app_terrain",
 *     uniqueConstraints={
 *          @UniqueConstraint(name="coordinates_idx", columns={"x", "y"})
 *     }
 * )
 * @AppValidation\UniqueTerrainCoordinates()
 */
class Terrain
{
    const SIZE_X = 10;
    const SIZE_Y = 10;

    use IdTrait;
    use UpdateAtTrait;
    use CreatedAtTrait;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("integer")
     * @JMS\Groups({"collection","details"})
     */
    private $x;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("integer")
     * @JMS\Groups({"collection","details"})
     */
    private $y;

    /**
     * @var Mob
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Mob", cascade={"persist", "remove"})
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Mob>")
     * @JMS\Groups({"collection","details"})
     */
    private $mob;

    /**
     * @param integer $x
     * @param integer $y
     * @param Mob $mob
     */
    public function __construct($x, $y, Mob $mob)
    {
        $this->x = $x;
        $this->y = $y;
        $this->mob = $mob;

        $this->updatedAt = new DateTime();
        $this->createdAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return Mob
     */
    public function getMob(): Mob
    {
        return $this->mob;
    }
}
