<?php

namespace App\Form;

use App\Entity\OpeningHour;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class OpeningHourEditAdminType extends AbstractType
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('morningOpen', TimeType::class, [
                'label' => 'Heure d\'ouverture le matin',
                'attr' => ['class' => 'custom-time'],
            ])
        ->add('morningClose', TimeType::class, [
            'label' => 'Heure de fermeture le matin',
            'attr' => ['class' => 'custom-time'],
        ])
        ->add('afternoonOpen', TimeType::class, [
            'label' => 'Heure d\'ouverture l\'après-midi',
            'attr' => ['class' => 'custom-time'],
        ])
        ->add('afternoonClose', TimeType::class, [
            'label' => 'Heure de fermeture l\'après-midi',
            'attr' => ['class' => 'custom-time'],
        ])
        ->add('dayOfWeek',EntityType::class, [
            'disabled' => false,
            'class' => OpeningHour::class,
            'label' => "Jour de la semaine",
            'choice_label' => function ($dayOfWeek) {
                return $this->translator->trans(strtolower($dayOfWeek));
            },
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