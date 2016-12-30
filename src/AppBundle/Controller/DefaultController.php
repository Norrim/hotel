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
     * @param string $route
     * @param array $routeParams
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function menuAction($route, $routeParams)
    {
        $rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();

        return [
            "rooms"       => $rooms,
            "route"       => $route,
            "routeParams" => $routeParams,
        ];
    }
}
