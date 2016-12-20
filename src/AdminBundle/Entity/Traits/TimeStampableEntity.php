<?php

namespace AdminBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Vincent Tiertant <vinz.tiertant@gmail.com>
 */
trait TimeStampableEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name = "created_at",
     *     type = "datetime"
     * )
     *
     * @Gedmo\Timestampable(on = "create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name = "updated_at",
     *     type = "datetime"
     * )
     *
     * @Gedmo\Timestampable(on = "update")
     */
    private $updatedAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
