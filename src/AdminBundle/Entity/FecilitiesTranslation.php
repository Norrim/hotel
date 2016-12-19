<?php
namespace AdminBundle\Entity;

use AdminBundle\Entity\Traits\TranslatableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fecilities_translations")
 */
class FecilitiesTranslation
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
     * @ORM\ManyToOne(targetEntity="Fecilities", inversedBy="translations")
     * @ORM\JoinColumn(name="fecilities_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $fecilities;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Fecilities
     */
    public function getFecilities()
    {
        return $this->fecilities;
    }

    /**
     * @param Fecilities $fecilities
     */
    public function setFecilities(Fecilities $fecilities)
    {
        $this->fecilities = $fecilities;
    }
}
