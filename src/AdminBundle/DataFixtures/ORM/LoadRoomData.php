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

        $room = new Room(true);
        $room->setPrice(49.0);

        $content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac velit justo. Mauris vitae nisl felis. Vestibulum vel sem rutrum, malesuada mauris sit amet, tempus lacus. Ut consectetur, sapien vitae lobortis pharetra, neque massa bibendum ipsum, sit amet venenatis ex urna luctus neque. Fusce vel faucibus elit, eu molestie mauris. Nam urna erat, condimentum eget sollicitudin eu, imperdiet porta nisi. Donec lacus ex, malesuada sit amet massa ut, aliquam malesuada nibh. Fusce molestie placerat nisi, at ornare elit imperdiet vel. Maecenas rutrum mauris molestie tempus tempus. In hac habitasse platea dictumst.</p>

<p>Morbi ultricies, nulla vel congue consequat, erat est consequat metus, bibendum consequat urna purus sit amet tellus. Cras felis leo, condimentum sed purus id, molestie condimentum elit. Etiam laoreet est dui, ac dapibus elit vehicula elementum. Nullam quis lectus pulvinar, dignissim elit vitae, fermentum diam. Nulla elit leo, aliquam in tristique id, rhoncus non sapien. Fusce in lorem tortor. Duis venenatis, augue rutrum consectetur tincidunt, ligula felis dignissim metus, id sollicitudin quam sem et purus. Mauris vestibulum quam nunc. Suspendisse vulputate odio turpis, eget auctor quam venenatis eu. Praesent ut malesuada odio. Donec id hendrerit diam, vitae malesuada lectus. Nullam ut condimentum ligula. Nullam tempus risus leo, fringilla laoreet lectus tempor a. Aliquam eget viverra dolor.</p>

<p>Nunc luctus dolor vel posuere ullamcorper. In metus justo, feugiat a sapien ut, tempor feugiat lacus. Sed non leo vel quam ullamcorper dictum. Sed pulvinar facilisis eros, non volutpat nulla auctor eget. Etiam eros nunc, tempor sit amet ex id, accumsan fermentum massa. Nulla commodo lorem ac felis commodo ultrices. Proin luctus dictum nisi eu tempus. In tincidunt in tellus eget pulvinar. Ut ipsum nunc, consectetur ac blandit nec, pulvinar vitae felis. Nam eget lectus eget felis dictum consectetur sit amet semper massa. Donec quis mi dapibus, sodales enim ut, pellentesque orci. In eget lectus sollicitudin, vulputate metus non, suscipit nisl. Aenean at enim eget sapien sollicitudin maximus nec sed neque.</p>

<p>Mauris eleifend enim ligula, porttitor egestas velit dignissim vel. Aliquam erat volutpat. Vivamus a lacus elementum tellus convallis ornare in nec sem. Aenean erat orci, semper in lectus vitae, commodo lobortis diam. Morbi mollis et turpis id laoreet. Nunc sed iaculis lorem, eu ullamcorper ante. Duis velit diam, facilisis tristique est eu, rhoncus mollis risus. Nullam ut volutpat augue. Aenean magna dui, euismod et enim et, facilisis varius lorem. Proin sit amet mauris vel arcu laoreet viverra fringilla tempor nulla.</p>

<p>Vestibulum porttitor orci nibh, ut ornare ante vestibulum non. Fusce malesuada urna ac orci accumsan ornare. Vivamus convallis mi quam, in euismod lacus iaculis a. Curabitur mattis mattis arcu eu tempus. Quisque fringilla non felis vitae cursus. Nam sit amet varius diam. Etiam tincidunt erat vitae consequat vulputate. Praesent finibus rhoncus nisl, id vulputate sem euismod a. Fusce vitae tortor dui. Quisque placerat non dolor at feugiat. Vestibulum congue tristique lobortis. Curabitur odio lorem, dapibus a porttitor eget, bibendum a erat. Aenean sollicitudin urna pretium urna porttitor, nec mattis ex gravida. Donec nisi arcu, convallis sed nisl vel, vestibulum dapibus nunc.</p>";

        $translation = new RoomTranslation();
        $translation->setLocale('fr');
        $translation->setName('Chambre VIP');
        $translation->setDescription('Description de la chambre');
        $translation->setContent($content);

        $translation2 = new RoomTranslation();
        $translation2->setLocale('en');
        $translation2->setName('Room VIP');
        $translation2->setDescription('Room\'s Description');
        $translation2->setContent($content);

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
