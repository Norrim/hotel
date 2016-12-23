<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route(
     *     name = "app_homepage",
     * )
     *
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction()
    {
        $bestRooms = $this->getDoctrine()->getRepository(Room::class)->findBy(["isBest" => true]);

        return ["bestRooms" => $bestRooms];
    }
}
