<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Faker\Provider\kk_KZ\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('password',PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'custom-input','placeholder' => "Minimum 12 caractères"],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Type de Compte',
                'choices' => [
                    'Compte Employé' => 'ROLE_USER',
                    'Compte Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('lastname',TextType::class, [
                'label' => 'Prenom',
                'attr' => ['class' => 'custom-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
