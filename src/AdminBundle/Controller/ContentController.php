<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Content;
use AdminBundle\Entity\Image;
use AdminBundle\Form\Type\ContentType;
use AdminBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends Controller
{
    /**
     * @Route(
     *     name = "admin_content",
     * )
     *
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction()
    {
        $contents = $this->getDoctrine()->getRepository(Content::class)->findAll();

        return [
            'contents' => $contents,
        ];
    }

    /**
     * @Route(
     *     name = "admin_content_add",
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
        $content = new Content();

        $form = $this->createForm(ContentType::class, $content);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($content);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement du contenu effectué avec succès !");

                return $this->redirect($this->generateUrl('admin_content'));
            }
        }

        return [
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_content_edit",
     *     requirements = {
     *         "content" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Content $content
     * @param Request $request
     *
     * @return Response
     *
     */
    public function editAction(Content $content, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ContentType::class, $content);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($content);
                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement du contenu effectué avec succès !");

                return $this->redirect($this->generateUrl('admin_content'));
            }
        }

        return [
            'content'   => $content,
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_content_delete",
     *     requirements = {
     *         "content" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @param Content $content
     * @param Request $request
     *
     * @return Response
     *
     */
    public function deleteAction(Content $content, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $picture = $content->getPicture();

        if ($picture) {
            $picture->unlinkImage();
            $em->remove($picture);
            $em->flush();
        }


        $em->remove($content);
        $em->flush();

        $request->getSession()->getFlashBag()->add("notice", "Suppression du contenu effectué avec succès !");

        return $this->redirect($this->generateUrl('admin_content'));
    }

    /**
     * @Route(
     *     name = "admin_content_add_picture",
     *     requirements = {
     *         "content" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Content $content
     *
     * @return Response
     *
     */
    public function addPictureAction(Content $content, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $picture = new Image();

        $form = $this->createForm(ImageType::class, $picture);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $picture->uploadImage();
                $content->setPicture($picture);

                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'image principale effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_content'));
            }
        }

        return [
            'content'    => $content,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_content_delete_picture",
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

        return $this->redirect($this->generateUrl('admin_content'));
    }

    /**
     * @Route(
     *     name = "admin_content_edit_picture",
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
        $content = $picture->getContent();

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

                return $this->redirect($this->generateUrl('admin_content'));
            }
        }

        return [
            'content' => $content,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_content_add_gallery",
     *     requirements = {
     *         "content" = "\w+"
     *     },
     *     options = { "expose" = true }
     * )
     *
     * @Template
     *
     * @param Content $content
     *
     * @return Response
     *
     */
    public function addGalleryAction(Content $content, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = new Image();

        $form = $this->createForm(ImageType::class, $gallery);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $gallery->uploadImage();
                $content->addGalleriesImage($gallery);

                $em->flush();

                $request->getSession()->getFlashBag()->add("notice", "Enregistrement de l'image effectuée avec succès !");

                return $this->redirect($this->generateUrl('admin_content'));
            }
        }

        return [
            'content'    => $content,
            'form'    => $form->createView(),
        ];
    }

    /**
     * @Route(
     *     name = "admin_content_delete_gallery",
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

        return $this->redirect($this->generateUrl('admin_content'));
    }

    /**
     * @Route(
     *     name = "admin_content_edit_gallery",
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
        $content = $gallery->getContent();

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

                return $this->redirect($this->generateUrl('admin_content'));
            }
        }

        return [
            'content'    => $content,
            'form'    => $form->createView(),
        ];
    }
}
