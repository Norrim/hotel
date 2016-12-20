<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Entity\FecilitiesTranslation;
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
        return [];
    }
}
