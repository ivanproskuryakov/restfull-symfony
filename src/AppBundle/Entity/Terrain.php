<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use DateTime;

use AppBundle\Entity\Traits\IdTrait;
use AppBundle\Entity\Traits\CreatedAtTrait;
use AppBundle\Entity\Traits\UpdateAtTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity()
 * @ORM\Table(name="app_terrain")
 */
class Terrain
{
    const SIZE_X = 100;
    const SIZE_Y = 100;

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
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Mob")
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

}
