<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Offer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email",
                'attr' => ['class' => 'custom-input']
            ])
            ->add('subject',TextType::class, [
                'label' => "Sujet",
                'attr'=> ['class' => 'custom-input']])
            ->add('message',TextareaType::class, ['label'=> "Message",
                'attr'=> ['class' => 'custom-textarea']])
            ->add('isGeneralInquiry', CheckboxType::class, [
                'label' => 'Demande générale (non liée à un véhicule)',
                'required' => false,
                'attr' => ['class' => ''],
            ])
            ->add('offer', EntityType::class, [
                'label'=>'Annonce',
                'class' => Offer::class,
                'attr'=> ['class' => 'custom-input offer-field'],
                'choice_label' => function ($offer) {
                    $createdAtString = $offer->getCreatedAt()->format('Y-m-d H:i');
                    return $offer->getReference() . ' - ' . $offer->getOfferTitle() . ' ' . $createdAtString;
                },
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.reference', 'DESC');
                },
                'choice_value' => 'id',
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telephone',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
