<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\ParameterTranslation;
use AppBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm(ContactType::class,null,[
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('app_contact'),
            'method' => 'POST'
        ]);

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('app_contact');
                }else{
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return [
            'paramAddress' => $this->getParameterEntity('address'),
            'paramPhone' => $this->getParameterEntity('phone'),
            'paramEmail' => $this->getParameterEntity('email'),
            'form' => $form->createView()
        ];
    }

    /**
     * @param $datas
     */
    private function sendEmail($datas) {

        $message = \Swift_Message::newInstance()
            ->setSubject($datas['subject'])
            ->setFrom($datas['email'])
            ->setTo('contact@hotel-le-pressoir.com')
            ->setBody(
                $datas['message']
            )
        ;

        return $this->get('mailer')->send($message);
    }


    private function getParameterEntity($slug)
    {
        $parameter = $this->getDoctrine()->getRepository(ParameterTranslation::class)->findOneBy(["slug" => $slug]);

        return (!$parameter) ? null : $parameter->getParameter();
    }
}
