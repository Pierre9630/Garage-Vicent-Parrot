<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand',TextType::class, [
                'label' => 'Marque',
                'attr' => ['class' => 'custom-input word-break-auto'],
            ])
            ->add('model',TextType::class, [
                'label' => 'Modèle',
                'attr' => ['class' => 'custom-input word-break-auto'],
            ])
            ->add('year',IntegerType::class, [
                'label' => 'Année',
                'attr' => ['class' => 'custom-input word-break-auto','min' => 1900,'max' => date('Y')],
            ])
            ->add('doors', IntegerType::class, [
                'label' => 'Nombre Portes',
                'attr' => ['class' => 'custom-input word-break-auto','min' => 1,'max' => 10],
            ])
            ->add('power', IntegerType::class, [
                'label' => 'Puissance',
                'attr' => ['class' => 'custom-input word-break-auto','min' => 1,'max' => 10000],
            ])
            ->add('kilometers', IntegerType::class, [
                'label' => 'Kilometres',
                'attr' => ['class' => 'custom-input word-break-auto','min' => 500,'max' => 400000],
            ])
            ->add('price',MoneyType::class, [
                'label' => 'Prix',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'custom-input word-break-auto'],
                'required' => false, // Non-obligatory field Rend le champ non obligatoire
            ])
            ->add('typeFuel',TextType::class, [
                'label' => 'Energie',
                'attr' => ['class' => 'custom-input word-break-auto'],
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
