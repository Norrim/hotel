<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Image;
use AdminBundle\Entity\Room;
use AdminBundle\Form\Type\ImageType;
use AdminBundle\Form\Type\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de la chambre effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_room_edit",
     *     requirements = {
     *         "room" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Room $room
     * @param Request $request
     *
     * @return Response
     *
     */
    public function editAction(Room $room, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(RoomType::class, $room);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($room);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de la chambre effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'room'   => $room,
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_room_delete",
     *     requirements = {
     *         "room" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @param Room $room
     * @param Request $request
     *
     * @return Response
     *
     */
    public function deleteAction(Room $room, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $picture = $room->getPicture();

        if ($picture) {
            $picture->unlinkImage();
            $em->remove($picture);
            $em->flush();
        }


        $em->remove($room);
        $em->flush();

        $request->getSession()->getFlashBag()->add("notice", "Suppression de la chambre effectuée avec succès !");

        return $this->redirect($this->generateUrl('admin_room'));
    }

    /**
     * @Route(
     *     name = "admin_room_add_picture",
     *     requirements = {
     *         "room" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Room $room
     *
     * @return Response
     *
     */
    public function addPictureAction(Room $room, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $picture = new Image();

        $form = $this->createForm(ImageType::class, $picture);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $picture->uploadImage();
                $room->setPicture($picture);
                
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'image principale effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'room'    => $room,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_room_delete_picture",
     *     requirements = {
     *         "picture" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @param Image $picture
     * @param Request $request
     *
     * @return Response
     *
     */
    public function deletePictureAction(Image $picture, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $picture->unlinkImage();

        $em->remove($picture);
        $em->flush();

        $request->getSession()->getFlashBag()->add("notice", "Suppression de l'image principale effectuée avec succès !");

        return $this->redirect($this->generateUrl('admin_room'));
    }

    /**
     * @Route(
     *     name = "admin_room_edit_picture",
     *     requirements = {
     *         "picture" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Image $picture
     * @param Request $request
     *
     * @return Response
     *
     */
    public function editPictureAction(Image $picture, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $room = $picture->getRoom();

        $form = $this->createForm(ImageType::class, $picture);

        //on rend le champ file optionel
        $form->remove('file');
        $form->add('file', FileType::class ,array('required'=>false));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                //si le champ file n'est pas vide
                if (!is_null($form->getData()->getFile())) {
                    //si l'image a une url
                    if(!is_null($picture->getUrl())) {
                        //on supprime l'ancienne image
                        $picture->unlinkImage();
                    }
                    //on upload l'image
                    $picture->uploadImage();
                }
                else {
                    $picture->renameImage();
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'image principale effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'room'    => $room,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_room_add_gallery",
     *     requirements = {
     *         "room" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Room $room
     *
     * @return Response
     *
     */
    public function addGalleryAction(Room $room, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = new Image();

        $form = $this->createForm(ImageType::class, $gallery);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $gallery->uploadImage();
                $room->addGalleriesImage($gallery);

                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'image effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'room'    => $room,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_room_delete_gallery",
     *     requirements = {
     *         "gallery" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @param Image $gallery
     * @param Request $request
     *
     * @return Response
     *
     */
    public function deleteGalleryAction(Image $gallery, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $gallery->unlinkImage();

        $em->remove($gallery);
        $em->flush();

        $request->getSession()->getFlashBag()->add("notice", "Suppression de l'image effectuée avec succès !");

        return $this->redirect($this->generateUrl('admin_room'));
    }

    /**
     * @Route(
     *     name = "admin_room_edit_gallery",
     *     requirements = {
     *         "gallery" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Image $gallery
     * @param Request $request
     *
     * @return Response
     *
     */
    public function editGalleryAction(Image $gallery, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $room = $gallery->getRoom();

        $form = $this->createForm(ImageType::class, $gallery);

        //on rend le champ file optionel
        $form->remove('file');
        $form->add('file', FileType::class ,array('required'=>false));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                //si le champ file n'est pas vide
                if (!is_null($form->getData()->getFile())) {
                    //si l'image a une url
                    if(!is_null($gallery->getUrl())) {
                        //on supprime l'ancienne image
                        $gallery->unlinkImage();
                    }
                    //on upload l'image
                    $gallery->uploadImage();
                }
                else {
                    $gallery->renameImage();
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'image effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_room'));
            }
        }

        return [
            'room'    => $room,
            'form'    => $form->createView(),
        ];
    }
}
