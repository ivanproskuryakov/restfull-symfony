<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use DateTime;

trait UpdateAtTrait
{

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @JMS\Expose
     * @JMS\ReadOnly
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    protected $updatedAt;

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
