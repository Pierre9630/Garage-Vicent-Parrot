<?php

namespace App\Form;

use App\Entity\Contacts;
use App\Entity\Offers;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('subject')
            ->add('message')
            ->add('offer', EntityType::class, [
                'class' => Offers::class,
                'choice_label' => 'reference',
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
            'data_class' => Contacts::class,
        ]);
    }
}
