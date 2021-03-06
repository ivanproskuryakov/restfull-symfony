<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
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
    const ACTION_TYPE_ATTACK = 1;
    const ACTION_TYPE_DEFEND = 2;
    const ACTION_TYPE_RUN = 3;

    use IdTrait;
    use UpdateAtTrait;
    use CreatedAtTrait;

    /**
     * @var integer
     * @Assert\NotNull()
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Groups({"collection","details"})
     */
    private $type;

    /**
     * @var Mob
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mob", inversedBy="actions")
     * @JMS\Expose
     * @JMS\Type("AppBundle\Entity\Mob")
     * @JMS\Groups({"collection","details"})
     */
    private $mob;

    /**
     * @var User
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="actions")
     * @JMS\ReadOnly
     * @JMS\Expose
     * @JMS\Type("AppBundle\Entity\User")
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

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }
}
