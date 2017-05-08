<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Entity\ParameterTranslation;
use AdminBundle\Entity\Room;
use AdminBundle\Entity\RoomTranslation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RoomController extends Controller
{
    /**
     * @Route(
     *     name = "app_room",
     * )
     *
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction()
    {
        $rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();

        return [
            "rooms" => $rooms,
            'paramUrlLogis'   => $this->getParameterEntity('url-logis-1'),
        ];
    }
    /**
     *
     * @Route(
     *     name    = "app_room_view",
     *     options = { "expose" = true }
     * )
     *
     * @ParamConverter("roomTranslation", options={"mapping": {"slug": "slug"}})
     *
     * @Template
     *
     * @param RoomTranslation $roomTranslation
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(RoomTranslation $roomTranslation)
    {
        return [
            'room' => $roomTranslation->getRoom(),
            'paramUrlLogis'   => $this->getParameterEntity('url-logis-1'),
        ];
    }

    private function getParameterEntity($slug)
    {
        $parameter = $this->getDoctrine()->getRepository(ParameterTranslation::class)->findOneBy(["slug" => $slug]);

        return (!$parameter) ? null : $parameter->getParameter();
    }
}
