<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Room;
use AdminBundle\Entity\RoomTranslation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route(
     *     name = "admin_dashboard",
     * )
     *
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
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
        
        $em->persist($room);
        $em->flush();

        return [];
    }
}
