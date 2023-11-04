<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Contact;
use App\Entity\Offer;

use Doctrine\ORM\EntityRepository;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('reference', TextType::class, [
                'disabled' => true, // Rend le champ en lecture seule
            ])*/
            ->add('offer_title', TextType::class,[
                'label' => "Titre"
            ])
            //->add('car', CarsType::class)
            ->add('isExposed',CheckboxType::class, [
                'label' => "Afficher en Exposition ?",
                'required' => false,
                'data' => false,
            ])
            ->add('car', EntityType::class, [
                'label' => "Voiture",
                'class' => Car::class,
                'choice_label' => function ($car) {
                    return $car->getReference() . ' - ' . $car->getBrand() . ' ' . $car->getModel() . ' ' . $car->getYear();
                },
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.reference', 'DESC')
                    ->leftJoin('u.offer', 'ot')
                    ->where('ot.id IS NULL');
                },
                'choice_value' => 'id',
            ])
            
            ->add('images', FileType::class, [
                'label' => "Image(s) à Uploader",
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new Image([
                            'maxSize' => '5M',
                            'minWidth' => 1024,
                            'maxWidth' => 3840,
                            'minHeight'=> 768,
                            'maxHeight'=> 2160,
                            'maxWidthMessage' => 'L\'image doit faire {{ max_width }} pixels de large au maximum',
                            'mimeTypes' => ['image/gif', 'image/png', 'image/webp', 'image/jpeg'],
                            'mimeTypesMessage' => 'Veuillez télécharger une image au format TIFF, PNG, WebP ou JPEG.',
                        ])
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
