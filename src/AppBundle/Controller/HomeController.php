<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Content;
use AdminBundle\Entity\ContentTranslation;
use AdminBundle\Entity\Fecilities;
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
        $doctrine = $this->getDoctrine();
        $bestRooms = $doctrine->getRepository(Room::class)->findBy(["isBest" => true]);
        $fecilities = $doctrine->getRepository(Fecilities::class)->findAll();
        $aboutUs = $doctrine->getRepository(ContentTranslation::class)->findOneBy(["slug" => "about-us"]);

        $aboutUsContent = (!$aboutUs) ? null : $aboutUs->getContentEntity();

        return [
            "bestRooms"      => $bestRooms,
            "fecilities"     => $fecilities,
            "aboutUsContent" => $aboutUsContent,
        ];
    }
}
