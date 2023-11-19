<?php

namespace App\DataFixtures;

use App\Entity\OpeningHour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningHourFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('monday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);

        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('tuesday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('wednesday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        //$openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        //$openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('thursday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('friday');
        $openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('saturday');
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);
        /*$openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));*/
        $manager->persist($openinghours);

        $openinghours = new OpeningHour();
        $openinghours->setDayOfWeek('sunday');
        $openinghours->setNullifyMorning(false);
        $openinghours->setNullifyAfternoon(false);
        /*$openinghours->setMorningOpen(\DateTime::createFromFormat('H:i','08:30'));
        $openinghours->setMorningClose(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setAfternoonOpen(\DateTime::createFromFormat('H:i','14:30'));
        $openinghours->setAfternoonClose(\DateTime::createFromFormat('H:i','18:00'));*/
        $manager->persist($openinghours);

        $manager->flush();
    }
}
