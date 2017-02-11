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

class RoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('price', NumberType::class)
            ->add('isBest',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ]
                ]
            )
            ->add(
                'fecilitiesRoom',
                EntityType::class,
                [
                    'class' => 'AdminBundle\Entity\Fecilities',
                    'choice_label' => 'icon',
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
            ->add(
                'translations',
                CollectionType::class,
                [
                    'entry_type'   => RoomTranslationType::class,
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
                'data_class'    => 'AdminBundle\Entity\Room',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_room_form';
    }
}
