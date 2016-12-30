<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GalleryController extends Controller
{
    /**
     * @Route(
     *     name = "app_gallery",
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
        $galleries = $doctrine->getRepository(Image::class)->findAll();

        return [
            "galleries" => $galleries,
        ];
    }
}
