<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\Type\SeasonType;
use AdminBundle\Lib\Globals;
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
    private $priceLow;

    /**
     * @var float
     *
     * @ORM\Column(
     *     type = "float",
     * )
     */
    private $priceMedium;

    /**
     * @var float
     *
     * @ORM\Column(
     *     type = "float",
     * )
     */
    private $priceLarge;

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
     * @ORM\JoinColumn(
     *     onDelete = "cascade"
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

    public function __construct($isFixture = false)
    {
        $this->translations = new ArrayCollection();
        $this->fecilitiesRoom = new ArrayCollection();
        $this->galleries = new ArrayCollection();

        if (!$isFixture) {
            foreach(Globals::getLocales() as $locale) {
                $roomTranslation = new RoomTranslation();
                $roomTranslation->setLocale($locale);
                $this->addTranslation($roomTranslation);
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
            $picture->setRoom($this);
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
     * @param RoomTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(RoomTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setRoom($this);
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
    public function getPriceLow()
    {
        return $this->priceLow;
    }

    /**
     * @param float $price
     */
    public function setPriceLow($price)
    {
        $this->priceLow = $price;
    }

    /**
     * @return float
     */
    public function getPriceMedium()
    {
        return $this->priceMedium;
    }

    /**
     * @param float $price
     */
    public function setPriceMedium($price)
    {
        $this->priceMedium = $price;
    }

    /**
     * @return float
     */
    public function getPriceLarge()
    {
        return $this->priceLarge;
    }

    /**
     * @param float $price
     */
    public function setPriceLarge($price)
    {
        $this->priceLarge = $price;
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
        if (!$this->fecilitiesRoom->contains($fecilities)) {
            $this->fecilitiesRoom->add($fecilities);
        }

        return $this;
    }

    /**
     * @param Fecilities $fecilities
     */
    public function removeFecilities(Fecilities $fecilities)
    {
        $this->fecilitiesRoom->removeElement($fecilities);
    }

    /**
     * @param RoomTranslation $translation
     */
    public function removeTranslation(RoomTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * @return ArrayCollection
     */
    public function getFecilitiesRoom()
    {
        return $this->fecilitiesRoom;
    }

    public function getPrice()
    {
        $now = date('Y/m/d');
        $limits= [
           SeasonType::MEDIUM => $this->getPriceMedium(),
           SeasonType::LARGE => $this->getPriceLarge(),
           SeasonType::LOW => $this->getPriceLow(),
        ];

        $price = 0;

        foreach ($limits AS $key => $value) {
            $limit=date("Y").'/'.$key;
            if (strtotime($now)>=strtotime($limit)) {
                $price = $value;
            }
        }

        return $price;
    }
}
