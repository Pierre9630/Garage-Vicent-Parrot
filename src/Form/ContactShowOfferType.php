<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class ContactShowOfferType extends AbstractType
{
    protected static string $classForm = "form-control my-2";
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'attr' => [
                    'class' => self::$classForm,
                    'placeholder' => 'sous forme test@domaine.com',
                ],
            ])
            ->add('subject', TextType::class,[
                'label' => 'Sujet : ',
                'attr' => array(
                    'class' => self::$classForm,
                    'placeholder' => 'Maximum 88 Caractères !',
                    'maxlength' => 88
                )
            ])
            ->add('message',TextareaType::class,[
                'label' => 'Message :',
                'attr' => array(
                    'class' => 'form-control my-2 w-100 ',
                    'placeholder' => 'Maximum 255 Caractères !',
                    'maxlength' => 255,
                    'rows' => 5,

                )
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telephone :',
                'attr' => array(
                    'placeholder' => 'Format 0XXXXXXXXX ou +33XXXXXXXXX !',
                    'maxlength' => 255,
                    'class' => self::$classForm
                ),
                'constraints' => new Regex([
                    'pattern' => "/^(\+33|0033|0)(1|2|3|4|6|7|9)[0-9]{8}$/",
                    'message' => "Veuillez Entrer un numéro valide ! ",
                ])
            ])
            /*->add('offer', EntityType::class, [
                'class' => 'App\Entity\Offers',
                'choice_label' => 'reference',
                'disabled' => true, // Désactiver le champ
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');
                },
            ]);*/;
    }
}