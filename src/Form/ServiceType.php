<?php

namespace App\Form;

use App\Entity\Service;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,['label' => 'Nom du Service','attr' => ['class' => 'custom-input']])
            ->add('description',TextareaType::class,['label' => 'Description du Service',
                'attr' => ['class' => 'custom-textarea']])
            //->add('createdAt')
            //->add('modifiedAt')
            ->add('published',CheckboxType::class,[ 'label' => 'Publier?',
                'attr' => ['class' => 'custom-checkbox'],
                'required' => false,
                'data' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
