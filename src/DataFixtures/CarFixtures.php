<?php

namespace App\DataFixtures;

//use AllowDynamicProperties;
use App\Entity\Image;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Car;
use Faker;

//#[AllowDynamicProperties]
class CarFixtures extends Fixture //implements DependentFixtureInterface
{
    const BRAND = [
        'Volkswagen',
        'Mercedes-Benz',
        'Citroen',
        'Renault',
        'Alfa Romeo',
        'Audi',
        'Porsche',
        'Dacia',
        'Lada'
    ];
    const MODEL = [
        'Golf 8',
        'Classe E',
        'C3',
        'Megane RS',
        'Giulietta',
        'A4',
        '911',
        'Logan',
        'Nova'
    ];
    const YEAR = [
        2016,
        2020,
        2019,
        2018,
        2015,
        2018,
        2020,
        2012,
        1999
    ];
    const DOORS = [
        5,
        5,
        5,
        5,
        3,
        5,
        3,
        5,
        3
    ];
    const POWER = [
        250,
        200,
        90,
        250,
        170,
        200,
        450,
        75,
        75
    ];
    const KILOMETERS = [
        120000,
        60000,
        130000,
        70000,
        150000,
        50000,
        80000,
        150000,
        500000
    ];const DESCRIPTION = [
        "C'est ce que j'aimerai acheter",
        "La voiture classe",
        "C'est une C3",
        "Le PV est en route",
        "La belle italienne",
        "Un point de deal est dans le coin...",
        "Si j'ai la thune",
        "Pas cher et solide",
        "Une Lada..."
    ];const TYPE_FUEL = [
        'essence',
        'diesel',
        'diesel',
        'essence',
        'essence',
        'diesel',
        'essence',
        'diesel',
        'diesel'
    ];
    const PRICE = [
        40000,
        90000,
        120000,
        20000,
        25000,
        10000,
        180000,
        8000,
        4000
    ];
    const CREATED_AT = [
        '2023-09-25 10:00:00',
        '2023-09-26 10:00:00',
        '2023-09-27 10:00:00',
        '2023-09-29 12:00:00',
        '2023-09-29 10:00:00',
        '2023-09-30 10:00:00',
        '2023-10-01 10:00:00',
        '2023-10-28 10:00:00',
        '2023-10-27 10:00:00'

    ];
    const REFERENCES = [
        'C230925001',
        'C230926001',
        'C230927001',
        'C230929001',
        'C230929002',
        'C230930001',
        'C231015001',
        'C231026001',
        'C231026002'

    ];
   /* const Imagename = [
        'Golf',
        'ClasseE',
        'C3',
        'RS',
        'Giuletta',
        'A4'
    ];*/

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
    //$faker = new Faker\Factory();
        foreach (self::BRAND as $Index => $BrandName) {
            $car = new Car();
            $carsRepository = $this->entityManager->getRepository(\App\Entity\Car::class);
            $car->setBrand($BrandName);
            $car->setModel( (self::MODEL[$Index]));
            $car->setYear( (self::YEAR[$Index]));
            $car->setDoors(self::DOORS[$Index]);
            $car->setPower(self::POWER[$Index]);
            $car->setKilometers((self::KILOMETERS[$Index]));
            $car->setDescription( (self::DESCRIPTION[$Index]));
            $car->setTypeFuel( (self::TYPE_FUEL[$Index]));
            $car->setCreatedAt(new \DateTimeImmutable(self::CREATED_AT[$Index]));
            $car->setPrice(self::PRICE[$Index]);
            $car->setReference(self::REFERENCE[$Index]);//[$carsRepository->generateReferenceForDate(new \DateTimeImmutable(self::createdAt[$Index])));
            $offer = new Offer();
            $offer->setReference(self::class);
            //$car->setReference($carsRepository->generateReferenceForDate(new \DateTimeImmutable(self::createdAt[$Index])));            //$Images = $this->getDependencies();
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
