<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\GuestBook;
use AdminBundle\Entity\ParameterTranslation;
use AppBundle\Form\Type\GuestBookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class GuestBookController extends Controller
{
    /**
     * @Route(
     *     name = "app_guest_book",
     * )
     *
     * @Template
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $guestBook = new GuestBook();

        $form = $this->createForm(GuestBookType::class, $guestBook);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($guestBook);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Message envoyé avec succès ! L'administrateur du site doit maintenant le valider");

                return $this->redirect($this->generateUrl('app_guest_book'));
            }
        }

        $guestBooks = $this->getDoctrine()->getRepository(GuestBook::class)->findValidatedOrderDesc();

        return [
            'form'       => $form->createView(),
            'guestBooks' => $guestBooks,
        ];
    }
}
