<?php

namespace App\Form;

use App\Entity\Testimonial;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class TestimonialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => ['class' => 'custom-input']
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'custom-textarea'],
            ])
            /*->add('note', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '0 - Très Mauvais' => 0,
                    '1 - Mauvais' => 1,
                    '2 - Moyen' => 2,
                    '3 - Bon' => 3,
                    '4 - Très Bon' => 4,
                    '5 - Excellent' => 5,
                ],
                'placeholder' => 'Sélectionnez une note',
                'required' => true,
            ])*/
            ->add('note', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '0 - Très Mauvais' => 0,
                    '1 - Mauvais' => 1,
                    '2 - Moyen' => 2,
                    '3 - Bon' => 3,
                    '4 - Très Bon' => 4,
                    '5 - Excellent' => 5,
                ],
                'placeholder' => 'Sélectionnez une note',
                'required' => true,
            ])
            ->add('conditions', CheckboxType::class, [
                'label' => 'J\'accepte les conditions générales',
                'mapped' => true,
                'attr' => ['class' => 'custom-condition'],
                'constraints' => new IsTrue([
                    'message' => 'Vous devez accepter les conditions générales.',
                ]),
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
        ]);
    }
}
