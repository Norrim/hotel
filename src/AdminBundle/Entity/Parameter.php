<?php

namespace AdminBundle\Entity;

use AdminBundle\Lib\Globals;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Traits\TimeStampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="parameter")
 *
 * @author Vincent TIERTANT <vinz.tiertant@gmail.com>
 */
class Parameter
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
     * @ORM\OneToMany(
     *   targetEntity = "ParameterTranslation",
     *   mappedBy     = "parameter",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct($isFixture = false)
    {
        $this->translations = new ArrayCollection();

        if (!$isFixture) {
            foreach(Globals::getLocales() as $locale) {
                $parameterTranslation = new ParameterTranslation();
                $parameterTranslation->setLocale($locale);
                $this->addTranslation($parameterTranslation);
            }
        }
    }

    /**
     * @param ParameterTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(ParameterTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setParameter($this);
        }

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
     * @param ParameterTranslation $translation
     */
    public function removeTranslation(ParameterTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }
}
