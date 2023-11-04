<?php

namespace App\Form;

use App\Entity\OpeningHour;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $jourSemaineTraduction = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];
        $builder
            ->add('morningOpen')
            ->add('morningClose')
            ->add('afternoonOpen')
            ->add('afternoonClose')
            ->add('dayOfWeek',EntityType::class, [
                'class' => OpeningHour::class,
                'label' => "Jour de la semaine",
                'choice_label' => 'dayOfWeek',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.dayOfWeek', 'ASC');
                },
                'choice_value' =>'dayOfWeek',
            ])
        ;       
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHour::class,
        ]);
    }
}
