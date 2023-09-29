<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cars;
use Faker;

class CarsFixtures extends Fixture //implements DependentFixtureInterface
{
    const Brand = [
        'Volkswagen',
        'Mercedes-Benz',
        'Citroen',
        'Renault',
        'Alfa Romeo',
        'Audi',
        'Porsche'
    ];
    const Model = [
        'Golf',
        'Classe E',
        'C3',
        'Megane RS',
        'Giulietta',
        'A4',
        '911'
    ];
    const Year = [
        2016,
        2020,
        2019,
        2018,
        2015,
        2018,
        2020
    ];const Kilometers = [
        120000,
        60000,
        130000,
        70000,
        150000,
        50000,
        80000
    ];const Description = [
        '2016',
        '2020',
        '2019',
        '2018',
        '2015',
        '2018',
        '2020'
    ];const Type_fuel = [
        'essence',
        'diesel',
        'diesel',
        'essence',
        'essence',
        'diesel',
        'essence'
    ];
    const price = [
        10000,
        10000,
        10000,
        10000,
        10000,
        10000,
        10000
    ];
    /*const createdAt = [
        '2023-09-26 10:00:00',
        '2023-09-26 10:00:00',
        '2023-09-26 10:00:00',
        '2023-09-26 10:00:00',
        '2023-09-26 10:00:00',
        '2023-09-26 10:00:00'

    ];*/
   /* const Imagename = [
        'Golf',
        'ClasseE',
        'C3',
        'RS',
        'Giuletta',
        'A4'
    ];*/

    public function load(ObjectManager $manager): void
    {
    $faker = new Faker\Factory();
        foreach (self::Brand as $Index => $BrandName) {
            $car = new Cars();
            $car->setBrand($BrandName);
            $car->setModel( (self::Model[$Index]));
            $car->setYear( (self::Year[$Index]));
            $car->setKilometers((self::Kilometers[$Index]));
            $car->setDescription( (self::Description[$Index]));
            $car->setTypeFuel( (self::Type_fuel[$Index]));
            $car->setCreatedAt(new \DateTimeImmutable());
            $car->setPrice(self::price[$Index]);
            //$Images = $this->getDependencies();
            //$car->addImage( $this->getReference($Images[$Index]));

            /*if($Index == 3){
                dd($UserName.' '. self::Pass[$Index]);
            }*/

            $manager->persist($car);
        }


        //$manager->persist($user);
        $manager->flush();
    }

    /*public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [
            CarsFixtures::class,
            //ImagesFixtures::class,
        ];
    }*/
}
