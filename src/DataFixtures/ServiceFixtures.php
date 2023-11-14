<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture {
    const NAMES = [
        'Réparation des pièces courantes et d\'usure',
        'Réparation des pièces de sécurité garantie',
        'Carrosserie et Vitrage',
        'Controle Technique avec DEKRA'];
    const DESCRIPTIONS = [
        'blablablablaba',
        'blablablablaba',
        'blablablablaba',
        'blablablablaba'
    ];
    public function load(ObjectManager $manager): void
    {

        foreach (self::NAMES as $Index => $Names){
            $service = new Service();
            $service->setName($Names);
            $service->setDescription(self::DESCRIPTIONS[$Index]);
            $service->setCreatedAt(new \DateTimeImmutable);
            $service->setPublished(true);
            //$user->setPhone(self::PhoneNumbers[$Index]);
            //$this->addReference('user-reference', $user);
            /*if($Index == 3){
                dd($UserName.' '. self::Pass[$Index]);
            }*/

            $manager->persist($service);
        }
        $manager->flush();
    }
}


