<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Traits\TimeStampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="room")
 *
 * @author Vincent TIERTANT <vinz.tiertant@gmail.com>
 */
class Room
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
     * @var float
     *
     * @ORM\Column(
     *     type = "float",
     * )
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(
     *     type = "boolean",
     * )
     */
    private $isBest = false;

    /**
     * @ORM\OneToMany(
     *   targetEntity = "RoomTranslation",
     *   mappedBy     = "room",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * @ORM\ManyToMany(
     *   targetEntity = "Fecilities",
     *   cascade      = {"persist"}
     * )
     */
    private $fecilitiesRoom;

    /**
     * @ORM\OneToOne(
     *     targetEntity = "AdminBundle\Entity\Image",
     *     cascade      = {"persist","remove"}
     * )
     */
    private $picture;

    /**
     * @ORM\OneToMany(
     *   targetEntity = "Image",
     *   mappedBy     = "room",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $galleries;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->fecilitiesRoom = new ArrayCollection();
        $this->galleries = new ArrayCollection();
    }

    /**
     * @param Image $picture
     */
    public function setPicture(Image $picture = null)
    {
        $this->picture = $picture;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param RoomTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(RoomTranslation $translation)
    {
        $this->translations[] = $translation;
        $translation->setRoom($this);

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
        $image->setRoom($this);

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
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return boolean
     */
    public function isBest()
    {
        return $this->isBest;
    }

    /**
     * @param boolean $isBest
     */
    public function setIsBest($isBest)
    {
        $this->isBest = $isBest;
    }

    /**
     * @param Fecilities $fecilities
     *
     * @return $this
     */
    public function addFecilities(Fecilities $fecilities)
    {
        $this->fecilitiesRoom->add($fecilities);

        return $this;
    }

    /**
     * @param Fecilities $fecilities
     */
    public function removeFecilities(Fecilities $fecilities)
    {
        if ($this->fecilitiesRoom->contains($fecilities)) {
            $this->fecilitiesRoom->removeElement($fecilities);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getFecilitiesRoom()
    {
        return $this->fecilitiesRoom;
    }

    
}
