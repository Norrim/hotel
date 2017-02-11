<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Entity\Parameter;
use AdminBundle\Form\Type\FecilitiesType;
use AdminBundle\Form\Type\ParameterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ParameterController extends Controller
{
    /**
     * @Route(
     *     name = "admin_parameter",
     * )
     *
     * @Template
     *
     * @return Response
     *
     */
    public function indexAction()
    {
        $parameters = $this->getDoctrine()->getRepository(Parameter::class)->findAll();

        return [
            'parameters' => $parameters
        ];
    }

    /**
     * @Route(
     *     name = "admin_parameter_edit",
     *     requirements = {
     *         "parameter" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Parameter $parameter
     * @param Request $request
     *
     * @return Response
     *
     */
    public function editAction(Parameter $parameter, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ParameterType::class, $parameter);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($parameter);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement du paramètre effectué avec succès !");

                return $this->redirect($this->generateUrl('admin_parameter'));
            }
        }

        return [
            'parameter'   => $parameter,
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_parameter_add",
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
        $parameter = new Parameter();

        $form = $this->createForm(ParameterType::class, $parameter);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($parameter);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement du paramètre effectué avec succès !");

                return $this->redirect($this->generateUrl('admin_parameter'));
            }
        }

        return [
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_parameter_delete",
     *     requirements = {
     *         "parameter" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @param Parameter $parameter
     * @param Request $request
     *
     * @return Response
     *
     */
    public function deleteAction(Parameter $parameter, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($parameter);
        $em->flush();

        $request->getSession()->getFlashBag()->add("notice", "Suppression du paramètre effectué avec succès !");

        return $this->redirect($this->generateUrl('admin_parameter'));
    }
}
