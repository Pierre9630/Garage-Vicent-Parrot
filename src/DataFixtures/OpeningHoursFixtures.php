<?php

namespace App\DataFixtures;

use App\Entity\OpeningHours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningHoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $openinghours = new OpeningHours();
        $openinghours->setDayOfWeek('Monday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));

        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDayOfWeek('Tuesday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDayOfWeek('Wed');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDayOfWeek('Thursday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDayOfWeek('Friday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $manager->persist($openinghours);

        $manager->flush();
    }
}
