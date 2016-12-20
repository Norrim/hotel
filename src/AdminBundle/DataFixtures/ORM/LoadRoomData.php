<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Entity\Room;
use AdminBundle\Entity\RoomTranslation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoomData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var Fecilities $fecilities */
        $fecilities = $this->getReference('fecilities-1');
        /** @var Fecilities $fecilities2 */
        $fecilities2 = $this->getReference('fecilities-2');
        /** @var Fecilities $fecilities3 */
        $fecilities3 = $this->getReference('fecilities-3');

        $room = new Room();
        $room->setPrice(49.0);

        $translation = new RoomTranslation();
        $translation->setLocale('fr');
        $translation->setName('Chambre VIP');
        $translation->setDescription('Description de la chambre');
        $translation->setContent('Contenu');

        $translation2 = new RoomTranslation();
        $translation2->setLocale('en');
        $translation2->setName('Room VIP');
        $translation2->setDescription('Room\'s Description');
        $translation2->setContent('Content');

        $room->addTranslation($translation);
        $room->addTranslation($translation2);

        $room->addFecilities($fecilities);
        $room->addFecilities($fecilities2);
        $room->addFecilities($fecilities3);

        $manager->persist($room);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
