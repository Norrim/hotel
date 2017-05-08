<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Entity\GuestBook;
use AdminBundle\Entity\Parameter;
use AdminBundle\Form\Type\FecilitiesType;
use AdminBundle\Form\Type\ParameterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestBookController extends Controller
{
    /**
     * @Route(
     *     name = "admin_guest_book",
     * )
     *
     * @Template
     *
     * @return Response
     *
     */
    public function indexAction()
    {
        $guestBooks = $this->getDoctrine()->getRepository(GuestBook::class)->findAllOrderDesc();

        return [
            'guestBooks' => $guestBooks
        ];
    }

    /**
     * @Route(
     *     name = "admin_guest_book_toggle_is_validated"
     * )
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \HttpRequestException
     */
    public function toggleAjaxAction(Request $request)
    {
//        if ($this->getUser()->getType() !== UserType::ADMIN) {
//            throw new AccessDeniedException();
//        }

        if ($request->isXmlHttpRequest()) {

            $guestBook = $this->getDoctrine()->getRepository(GuestBook::class)->find($request->request->get('id'));

            if ($guestBook->isValidated()) {
                $guestBook->setIsValidated(false);
            }
            else {
                $guestBook->setIsValidated(true);
            }

            $this->getDoctrine()->getEntityManager()->flush();

            return new JsonResponse(['success' => 'success']);
        }

        throw new \HttpRequestException();
    }
}
