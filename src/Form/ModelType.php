<?php

namespace App\Form;

use App\Entity\Model;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Modèle',
                'attr' => [
                    'placeholder' => 'Nom du modèle'
                ]
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'attr' => [
                    'placeholder' => 'Nom du slug'
                ]

            ]);
        // ->add('createdAt', null, [
        //     'widget' => 'single_text',
        // ])
        // ->add('updatedAt', null, [
        //     'widget' => 'single_text',
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
