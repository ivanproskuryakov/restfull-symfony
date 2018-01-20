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
 * @ORM\Table(name="app_action")
 */
class Action
{
    const ACTION_KISS = '1';
    const ACTION_DANCE = '2';
    const ACTION_LOVE = '3';

    use IdTrait;
    use UpdateAtTrait;
    use CreatedAtTrait;

    /**
     * @var Terrain
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Terrain")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Terrain>")
     * @JMS\Groups({"collection","details"})
     */
    private $terrain;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\User>")
     * @JMS\Groups({"collection","details"})
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updatedAt = new DateTime();
        $this->createdAt = new DateTime();
    }

    /**
     * @return Terrain
     */
    public function getTerrain(): Terrain
    {
        return $this->terrain;
    }

    /**
     * @param Terrain $terrain
     */
    public function setTerrain(Terrain $terrain)
    {
        $this->terrain = $terrain;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

}
