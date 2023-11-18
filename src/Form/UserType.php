<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'custom-input'],
            ])
            //->add('roles',CollectionType::class)->setData("ROLE_USER")
            ->add('password',PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'custom-input','placeholder' => "Minimum 12 caractères 1 Lettre Majuscule 1 Chiffre 1 caractère spécial"],
            ])
            ->add('firstname',TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('lastname',TextType::class, [
                'label' => 'Prenom',
                'attr' => ['class' => 'custom-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
