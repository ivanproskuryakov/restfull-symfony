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
 * @ORM\Table(name="app_character")
 */
class Character
{
    use IdTrait;
    use UpdateAtTrait;
    use CreatedAtTrait;

    /**
     * @var string
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var int
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("integer")
     * @JMS\Groups({"collection","details"})
     * @ORM\Column(type="integer")
     */
    private $experience = 0;

    /**
     * @var User
     * @Gedmo\Blameable(on="create")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="character")
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getExperience(): int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience(int $experience)
    {
        $this->experience = $experience;
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
