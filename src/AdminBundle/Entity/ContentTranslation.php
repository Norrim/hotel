<?php
namespace AdminBundle\Entity;

use AdminBundle\Entity\Traits\TranslatableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content_translations")
 */
class ContentTranslation
{
    use TranslatableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="translations")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $contentEntity;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Content
     */
    public function getContentEntity()
    {
        return $this->contentEntity;
    }

    /**
     * @param Content $contentEntity
     */
    public function setContentEntity(Content $contentEntity)
    {
        $this->contentEntity = $contentEntity;
    }
}
