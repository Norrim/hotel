<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Room;
use AdminBundle\Form\Type\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    /**
     * @Route(
     *     name = "admin_room",
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
            'rooms' => $rooms,
        ];
    }

    /**
     * @Route(
     *     name = "admin_room_add",
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
        $room = new Room();

        $form = $this->createForm(RoomType::class, $room);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($room);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'room' => $room,
            'form'   => $form->createView(),
        ];
    }
    
    public function editAction($id)
    {
        $formHandler = $this->get('content_handler');

        $formHandler->bind($id,'AdminBundle:Content');

        if($formHandler->process()) {
            return $this->redirect($this->generateUrl('admin_content'));
        }

        $lineManager = $this->get('line_manager');

        return $this->render('AdminBundle:Content:edit.html.twig',array(
            'form' => $formHandler->createView(),
            'content' => $formHandler->getEntity(),
            'lineList' => $lineManager->getAllByContentId($id)
        ));
    }

    public function deleteAction($id)
    {
        $manager = $this->get('content_manager');

        $manager->delete($id);

        return $this->redirect($this->generateUrl('admin_content'));
    }
}
