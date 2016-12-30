<?php

namespace AdminBundle\Entity;

use AdminBundle\Lib\Globals;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Traits\TimeStampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="content")
 *
 * @author Vincent TIERTANT <vinz.tiertant@gmail.com>
 */
class Content
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
     *   targetEntity = "ContentTranslation",
     *   mappedBy     = "contentEntity",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * @ORM\OneToOne(
     *     targetEntity = "Image",
     *     cascade      = {"persist","remove"}
     * )
     * @ORM\JoinColumn(
     *     onDelete = "cascade"
     * )
     */
    private $picture;

    /**
     * @ORM\OneToMany(
     *   targetEntity = "Image",
     *   mappedBy     = "content",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $galleries;

    public function __construct($isFixture = false)
    {
        $this->translations = new ArrayCollection();
        $this->galleries = new ArrayCollection();

        if (!$isFixture) {
            foreach(Globals::getLocales() as $locale) {
                $contentTranslation = new ContentTranslation();
                $contentTranslation->setLocale($locale);
                $this->addTranslation($contentTranslation);
            }
        }
    }

    /**
     * @param Image $picture
     */
    public function setPicture(Image $picture = null)
    {
        $this->picture = $picture;

        if ($picture) {
            $picture->setContent($this);
        }
    }

    /**
     * @return Image
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param ContentTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(ContentTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setContentEntity($this);
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
     * @param Image $image
     *
     * @return $this
     */
    public function addGalleriesImage(Image $image)
    {
        $this->galleries[] = $image;
        $image->setContent($this);

        return $this;
    }

    /**
     * @param ArrayCollection $galleries
     */
    public function setGalleries($galleries)
    {
        $this->galleries->clear();
        foreach ($galleries as $image) {
            $this->addGaleriesImage($image);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getGalleries()
    {
        return $this->galleries;
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
     * @param ContentTranslation $translation
     */
    public function removeTranslation(ContentTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }
}
