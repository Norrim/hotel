<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FecilitiesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('icon', TextType::class)
            ->add(
                'translations',
                CollectionType::class,
                [
                    'entry_type'   => FecilitiesTranslationType::class,
                    'allow_add'    => false,
                    'allow_delete' => false,
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Enregistrer',
                    'attr' => ['class' => 'btn btn-success']
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'    => 'AdminBundle\Entity\Fecilities',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_fecilities_form';
    }
}
