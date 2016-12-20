<?php
namespace AdminBundle\Entity;

use AdminBundle\Entity\Traits\TranslatableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="room_translations")
 */
class RoomTranslation
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
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="translations")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $room;

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room)
    {
        $this->room = $room;
    }
}
