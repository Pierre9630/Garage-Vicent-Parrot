<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;
class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $carsData = [
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2020,
                'doors' => 4,
                'power' => 150,
                'kilometers' => 50000,
                'price' => 200000,
                'description' => 'Pack clim et toute option',
                'typeFuel' => 'Essence',
                'reference' =>'C230101001',
                'reference_for_date' => '23-01-01-001',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2018,
                'doors' => 4,
                'power' => 140,
                'kilometers' => 60000,
                'price' => 18000,
                'description' => '',
                'typeFuel' => 'Essence',
                'reference' =>'C230101002',
                'reference_for_date' => '23-01-01-002',
            ],
            [
                'brand' => 'Ford',
                'model' => 'Focus',
                'year' => 2019,
                'doors' => 5,
                'power' => 130,
                'kilometers' => 45000,
                'price' => 17000,
                'description' => 'Spacieuse et confortable, options bluetooth et gps',
                'typeFuel' => 'Diesel',
                'reference' =>'C230101003',
                'reference_for_date' => '23-01-01-003',
            ],
            [
                'brand' => 'Renault',
                'model' => 'Clio IV GT',
                'year' => 2019,
                'doors' => 5,
                'power' => 120,
                'kilometers' => 120000,
                'price' => 17000,
                'description' => 'Spacieuse et confortable, options bluetooth et gps',
                'typeFuel' => 'Diesel',
                'reference' =>'C230101004',
                'reference_for_date' => '23-01-01-004',
            ],
            [
                'brand' => 'BMW',
                'model' => '320i',
                'year' => 2017,
                'doors' => 5,
                'power' => 292,
                'kilometers' => 230000,
                'price' => 35000,
                'description' => 'Pack Sport',
                'typeFuel' => 'Essence',
                'reference' => 'C230101005',
                'reference_for_date' => '23-01-01-005',
            ],
        ];

        foreach ($carsData as $carData) {
            $car = new Car();
            $car->setBrand($carData['brand']);
            $car->setModel($carData['model']);
            $car->setYear($carData['year']);
            $car->setDoors($carData['doors']);
            $car->setPower($carData['power']);
            $car->setKilometers($carData['kilometers']);
            $car->setPrice($carData['price']);
            $car->setDescription($carData['description']);
            $car->setTypeFuel($carData['typeFuel']);
            $car->setReference($carData['reference']);

            $referenceParts = explode('-', $carData['reference_for_date']);
            $year = substr($referenceParts[0], 0, 2);
            $month = substr($referenceParts[1], 0, 2);
            $day = substr($referenceParts[2], 0, 2);

            $createdAt = new \DateTimeImmutable("C20$year$month$day");

            $car->setCreatedAt($createdAt);

            $manager->persist($car);
        }

        $manager->flush();
    }
}