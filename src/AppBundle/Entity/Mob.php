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
 * @ORM\Table(name="app_mob")
 */
class Mob
{
    const TYPE_DISCO = 1;
    const TYPE_ROCK = 2;
    const TYPE_POP = 3;
    const TYPE_COUNTRY = 4;
    const TYPE_EBM = 5;

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
    private $type;

    /**
     * @var Action[]
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Action", mappedBy="mob", cascade={"remove"})
     * @JMS\Type("ArrayCollection<AppBundle\Entity\Action>")
     * @JMS\Groups({"collection","details"})
     */
    private $actions;

    /**
     * @param integer $type
     */
    public function __construct($type)
    {
        $this->type = $type;
        $this->updatedAt = new DateTime();
        $this->createdAt = new DateTime();
    }

    /**
     * @return integer
     */
    public static function getRandomType()
    {
        return array_rand(
            [
                self::TYPE_DISCO,
                self::TYPE_ROCK,
                self::TYPE_POP,
                self::TYPE_COUNTRY,
                self::TYPE_EBM
            ]
        );
    }

    /**
     * @return Action[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param Action[] $actions
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;
    }


}
