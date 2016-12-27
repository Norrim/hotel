<?php

namespace AdminBundle\Entity;

use AdminBundle\Lib\Globals;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Traits\TimeStampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fecilities")
 *
 * @author Vincent TIERTANT <vinz.tiertant@gmail.com>
 */
class Fecilities
{
    use TimeStampableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type   = "string",
     *     length = 255
     * )
     */
    private $icon;

    /**
     * @ORM\OneToMany(
     *   targetEntity = "FecilitiesTranslation",
     *   mappedBy     = "fecilities",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct($isFixture = false)
    {
        $this->translations = new ArrayCollection();

        if (!$isFixture) {
            foreach(Globals::getLocales() as $locale) {
                $fecilitiesTranslation = new FecilitiesTranslation();
                $fecilitiesTranslation->setLocale($locale);
                $this->addTranslation($fecilitiesTranslation);
            }
        }
    }
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
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @param FecilitiesTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(FecilitiesTranslation $translation)
    {
        $this->translations[] = $translation;
        $translation->setFecilities($this);

        return $this;
    }

    /**
     * @param ArrayCollection $translations
     */
    public function setTranslations($translations)
    {
        $this->translations->clear();
        foreach ($translations as $translation) {
            $this->addTranslation($translation);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
