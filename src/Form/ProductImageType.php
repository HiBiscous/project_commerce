<?php

namespace App\Form;

use App\Entity\ProductImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageName', TextType::class, [
                'label' => 'Nom de l\'image',
                'attr' => [
                    'placeholder' => 'Nom de l\'image'
                ]
            ])
            // ->add('productId')
            ->add('imageSize', IntegerType::class, [
                'label' => 'Taille de l\'image (en pixel)',
                'attr' => [
                    'placeholder' => 'Taille de votre image'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductImage::class,
        ]);
    }
}
