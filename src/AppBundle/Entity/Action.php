<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;
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
    use IdTrait;
    use UpdateAtTrait;
    use CreatedAtTrait;

    /**
     * @var Mob
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Mob")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Mob>")
     * @JMS\Groups({"collection","details"})
     */
    private $mob;

    /**
     * @var User
     * @Gedmo\Blameable(on="create")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @JMS\ReadOnly
     * @JMS\Type("ArrayCollection<AppBundle\Entity\User>")
     * @JMS\Groups({"collection","details"})
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return Mob
     */
    public function getMob(): Mob
    {
        return $this->mob;
    }

    /**
     * @param Mob $mob
     */
    public function setMob(Mob $mob)
    {
        $this->mob = $mob;
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
