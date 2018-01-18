<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\Traits\IdTrait;
use AppBundle\Entity\Traits\UpdateCreateTrait;
use DateTime;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity()
 * @ORM\Table(name="app_challenge")
 */
class Challenge
{
    const STATUS_STARTED = '1';
    const STATUS_COMPLETED = '2';

    use IdTrait;
    use UpdateCreateTrait;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("integer")
     * @JMS\Groups({"collection","details"})
     */
    protected $status = self::STATUS_STARTED;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\MaxDepth(1)
     * @JMS\Type("AppBundle\Entity\User")
     * @JMS\Groups({"collection","details"})
     */
    private $challenger;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\User>")
     * @JMS\Groups({"collection","details"})
     */
    private $challengeable;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\MaxDepth(1)
     * @JMS\Type("AppBundle\Entity\User")
     * @JMS\Groups({"collection","details"})
     */
    private $winner;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updatedAt = new DateTime();
        $this->createdAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getChallenger(): User
    {
        return $this->challenger;
    }

    /**
     * @param User $challenger
     */
    public function setChallenger(User $challenger)
    {
        $this->challenger = $challenger;
    }

    /**
     * @return User
     */
    public function getChallengeable(): User
    {
        return $this->challengeable;
    }

    /**
     * @param User $challengeable
     */
    public function setChallengeable(User $challengeable)
    {
        $this->challengeable = $challengeable;
    }

    /**
     * @return User
     */
    public function getWinner(): User
    {
        return $this->winner;
    }

    /**
     * @param User $winner
     */
    public function setWinner(User $winner)
    {
        $this->winner = $winner;
    }

}
