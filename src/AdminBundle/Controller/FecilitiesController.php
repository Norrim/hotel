<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Form\Type\FecilitiesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FecilitiesController extends Controller
{
    /**
     * @Route(
     *     name = "admin_fecilities",
     * )
     *
     * @Template
     *
     * @return Response
     *
     */
    public function indexAction()
    {
        $fecilities = $this->getDoctrine()->getRepository(Fecilities::class)->findAll();

        return [
          'fecilities' => $fecilities
        ];
    }

    /**
     * @Route(
     *     name = "admin_fecilities_edit",
     *     requirements = {
     *         "fecilities" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Fecilities $fecilities
     * @param Request $request
     *
     * @return Response
     *
     */
    public function editAction(Fecilities $fecilities, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(FecilitiesType::class, $fecilities);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($fecilities);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'aménagement effectué avec succès !");

                return $this->redirect($this->generateUrl('admin_fecilities'));
            }
        }

        return [
            'fecilities'   => $fecilities,
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_fecilities_add",
     * )
     *
     * @Template
     *
     * @param Request $request
     *
     * @return Response
     *
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fecilities = new Fecilities();

        $form = $this->createForm(FecilitiesType::class, $fecilities);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($fecilities);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'aménagement effectué avec succès !");

                return $this->redirect($this->generateUrl('admin_fecilities'));
            }
        }

        return [
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_fecilities_delete",
     *     requirements = {
     *         "fecilities" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @param Fecilities $fecilities
     * @param Request $request
     *
     * @return Response
     *
     */
    public function deleteAction(Fecilities $fecilities, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($fecilities);
        $em->flush();

        $request->getSession()->getFlashBag()->add("notice", "Suppression de l'aménagement effectué avec succès !");

        return $this->redirect($this->generateUrl('admin_fecilities'));
    }
}
