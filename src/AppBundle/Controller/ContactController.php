<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\ParameterTranslation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ContactController extends Controller
{
    /**
     * @Route(
     *     name = "app_contact",
     * )
     *
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction()
    {
        return [
            'paramAddress' => $this->getParameterEntity('address'),
            'paramPhone' => $this->getParameterEntity('phone'),
            'paramEmail' => $this->getParameterEntity('email'),
        ];
    }


    private function getParameterEntity($slug)
    {
        $parameter = $this->getDoctrine()->getRepository(ParameterTranslation::class)->findOneBy(["slug" => $slug]);

        return (!$parameter) ? null : $parameter->getParameter();
    }
}
