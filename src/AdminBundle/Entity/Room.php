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
     *   mappedBy     = "object",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
}
