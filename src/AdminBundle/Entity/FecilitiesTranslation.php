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
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type   = "string",
     *     length = 255,
     * )
     */
    private $name;

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

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
