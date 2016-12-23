<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route(
     *     name = "app_default_menu",
     * )
     *
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function menuAction()
    {
        $rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();

        return ["rooms" => $rooms];
    }
}
