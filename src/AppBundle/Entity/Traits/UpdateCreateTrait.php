<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

trait UpdateCreateTrait
{

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    protected $updatedAt;

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
