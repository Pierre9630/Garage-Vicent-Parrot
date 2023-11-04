<?php

namespace App\Form;

use App\Entity\Cars;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Brand',TextType::class, [
                'attr' => [
                    'placeholder' => "Marque"
                ]
            ])
            ->add('Model',TextType::class,[
                           'label' => "Modèle du vehicule",
                            'required' => false,
            ])
            //[
            //                'label' => "Modèle du vehicule"
            //            ]
            ->add('Year',NumberType::class,[
            'required' => false,
            ])
            ->add('kilometers',NumberType::class,[
                'required' => false,
            ])
            ->add('description',TextType::class,[
                'required' => false,
            ])
            //->add('Image1')
            ->add('TypeFuel',TextType::class,[
                'required' => false,
            ])
        ;
    }
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'ensureOneFieldIsSubmitted',
        ];
    }
//https://chrisguitarguy.com/2020/04/29/symfony-forms-at-least-one-field-required/
    public function ensureOneFieldIsSubmitted(FormEvent $event)
    {
        $submittedData = $event->getData();

        // just checking for `null` here, but you may want to check for an empty string or something like that
        if (!isset($submittedData['Brand'])) {
            throw new TransformationFailedException(
                'either one field must be set',
                0, // code
                null, // previous
                'Either the first and/or second field must be set', // user message
                ['{{ whatever }}' => 'here'] // message context for the translater
            );
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
            'car_class' => Cars::class,
        ]);
    }
}
