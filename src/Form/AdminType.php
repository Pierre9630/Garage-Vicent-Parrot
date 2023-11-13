<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Faker\Provider\kk_KZ\Text;
use Symfony\Component\Form\AbstractType;
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
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'custom-input']
            ])
            ->add('roles',CollectionType::class,[
                'attr' => ['class' => 'custom-input']
            ])
            ->add('password',PasswordType::class,[
                'attr' => ['class' => 'custom-input']
            ])
            ->add('firstname',TextType::class,[
                'attr' => ['class' => 'custom-input']
            ])
            ->add('lastname',TextType::class,
                ['attr' => ['class' => 'custom-input']])
            //->add('phone', TelType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
