<?php

namespace AdminBundle\Entity;

use AdminBundle\Lib\Globals;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Traits\TimeStampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="guest_book")
 *
 * @author Vincent TIERTANT <vinz.tiertant@gmail.com>
 */
class GuestBook
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
     *     length = 255,
     * )
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(type = "text")
     */
    private $message;

    /**
     * @var boolean
     *
     * @ORM\Column(
     *     type = "boolean",
     *     name = "is_validated"
     * )
     */
    private $isValidated = false;

    /**
     * @var integer
     *
     * @ORM\Column(type = "integer")
     */
    private $mark = 5;

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
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return boolean
     */
    public function isValidated()
    {
        return $this->isValidated;
    }

    /**
     * @param boolean $isValidated
     */
    public function setIsValidated($isValidated)
    {
        $this->isValidated = $isValidated;
    }

    /**
     * @return int
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param int $mark
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
    }
}
