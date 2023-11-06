<?php

namespace App\DataFixtures;

use App\Entity\OpeningHour;
use App\Repository\OfferRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningHourFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('Monday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        

        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('Tuesday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('Wednesday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        //$openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        //$openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('Thursday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('Friday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $manager->flush();
    }
}
