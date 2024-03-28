<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Offer;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceValue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;

class OfferEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('reference', TextType::class, [
                'disabled' => true, // Make field Read-only Rend le champ en lecture seule
                'attr' => ['class' => 'custom-input'],
            ])
            ->add('isExposed', ChoiceType::class, [
                'label' => "Afficher en Exposition ?",
                'required' => false,
                'attr' => ['class' => 'custom-checkbox'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],

            ])
            //->add('car', CarsType::class)

            ->add('images', FileType::class, [
                'label' => "Image(s) à Uploader",
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All(
                        new Image([
                            'maxSize' => '4M',
                            'minWidth' => 1024,
                            'maxWidth' => 3840,
                            'minHeight'=> 768,
                            'maxHeight'=> 2160,
                            'maxWidthMessage' => 'L\'image doit faire {{ max_width }} pixels de large au maximum',
                            'mimeTypes' => ['image/gif', 'image/png', 'image/webp', 'image/jpeg'],
                            'mimeTypesMessage' => 'Veuillez télécharger une image au format TIFF, PNG, WebP ou JPEG.',
                        ])
                    )
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