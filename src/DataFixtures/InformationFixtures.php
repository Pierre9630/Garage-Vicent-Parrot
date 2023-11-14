<?php

namespace App\DataFixtures;

use App\Entity\Information;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InformationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


            $service = new Information();
            $service->setCorpPhone('0240689887');
            $service->setAddress('30 rue des nantais');
            $service->setCity('Nantes');
            $service->setCorpEmail('garagevparrot@orange.fr');
            $service->setActive(true);
            //$user->setPhone(self::PhoneNumbers[$Index]);
            //$this->addReference('user-reference', $user);
            /*if($Index == 3){
                dd($UserName.' '. self::Pass[$Index]);
            }*/

            $manager->persist($service);

        $manager->flush();
    }
}