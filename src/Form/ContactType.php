<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Offer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, ['label'=> "Email"])
            ->add('subject',TextType::class, ['label'=> "Sujet"])
            ->add('message',TextareaType::class, ['label'=> "Message"])
            ->add('offer', EntityType::class, [
                'class' => Offer::class,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
