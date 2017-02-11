<?php

namespace AdminBundle\Form\Type;

use AdminBundle\Entity\FecilitiesTranslation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'translations',
                CollectionType::class,
                [
                    'entry_type'   => ParameterTranslationType::class,
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
                'data_class'    => 'AdminBundle\Entity\Parameter',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_parameter_form';
    }
}
