<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class ContactShowOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email :'
            ])
            ->add('subject', TextType::class,[
                'label' => 'Sujet : ',
                'attr' => array(
                    'placeholder' => 'Maximum 88 Caractères !',
                    'maxlength' => 88
                )
            ])
            ->add('message',TextType::class,[
                'label' => 'Message :',
                'attr' => array(
                    'placeholder' => 'Maximum 255 Caractères !',
                    'maxlength' => 255
                )
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telephone :',
                'attr' => array(
                    'placeholder' => 'Format 0XXXXXXXXX ou +33XXXXXXXXX !',
                    'maxlength' => 255,
                    'class' => 'message-input'
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