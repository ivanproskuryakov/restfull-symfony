<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use DateTime;

trait CreatedAtTrait
{
    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    protected $createdAt;

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}
