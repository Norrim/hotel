<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                 'constraints' => [
                     new NotBlank(["message" => "Please provide your name"]),
                 ],
                 'attr' => [
                     'class' => 'form-control'
                 ]
            ])
            ->add('subject', TextType::class, [
                'constraints' => [
                    new NotBlank(["message" => "Please give a Subject"]),
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(["message" => "Please provide a valid email"]),
                    new Email(["message" => "Your email doesn't seems to be valid"]),
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new NotBlank(["message" => "Please provide a message here"]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'error_bubbling'    => true,
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_contact_form';
    }
}
