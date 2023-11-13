<?php

namespace App\Form;

use App\Entity\Information;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('corp_phone',TextType::class,[
                'label' => 'Telephone :',
                'attr' => array(
                    'placeholder' => 'Format 0XXXXXXXXX ou +33XXXXXXXXX !',
                    'maxlength' => 255,
                    'class' => 'custom-input'
                ),
                'constraints' => new Regex([
                    'pattern' => "/^(\+33|0033|0)(1|2|3|4|6|7|9)[0-9]{8}$/",
                    'message' => "Veuillez Entrer un numéro valide ! ",
                ])
            ])
            ->add('address', TextType::class, ['label'=> "Addresse",
                'attr' => ['class' => 'custom-input'],
                ])
            ->add('city', TextType::class, ['label'=> "Ville",
                'attr' => ['class' => 'custom-input']
                ])
            ->add('corp_email',EmailType::class, ['label'=> "Email",
            'attr' => ['class' => 'custom-input']
            ])
            ->add('active', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'custom-checkbox'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
        ]);
    }
}
