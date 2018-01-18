<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use DateTime;

use AppBundle\Entity\Traits\IdTrait;
use AppBundle\Entity\Traits\UpdateCreateTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity()
 * @ORM\Table(name="app_action")
 */
class Action
{

    use IdTrait;
    use UpdateCreateTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updatedAt = new DateTime();
        $this->createdAt = new DateTime();
    }


}
