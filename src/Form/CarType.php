<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand',TextType::class, [
                'label' => 'Marque',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('model',TextType::class, [
                'label' => 'Modèle',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('year',IntegerType::class, [
                'label' => 'Année',
                'attr' => ['class' => 'custom-input'],
                /*'min' => date('Y') - 100,
                'max' => date('Y') + 10,*/
            ])
            ->add('doors', IntegerType::class, [
                'label' => 'Nombre Portes',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('power', IntegerType::class, [
                'label' => 'Puissance',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('kilometers', IntegerType::class, [
                'label' => 'Kilometres',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('price',MoneyType::class, [
                'label' => 'Prix',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('typeFuel',TextType::class, [
                'label' => 'Energie',
                'attr' => ['class' => 'custom-input'],
            ])
            /*->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All(
                        new Image([
                            'maxWidth' => 1280,
                            'maxWidthMessage' => 'L\'image doit faire {{ max_width }} pixels de large au maximum'
                        ])
                    )
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
