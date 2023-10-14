<?php

namespace App\Form;

use App\Entity\OpeningHours;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('morningOpen')
            ->add('morningClose')
            ->add('afternoonOpen')
            ->add('afternoonClose')
            ->add('dayOfWeek',EntityType::class, [
                'class' => OpeningHours::class,
                'choice_label' => 'dayOfWeek',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.dayOfWeek', 'ASC');
                },
                'choice_value' => 'dayOfWeek',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHours::class,
        ]);
    }
}
