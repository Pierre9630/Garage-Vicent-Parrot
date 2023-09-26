<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends Fixture
{
    const name = [
        'Golf',
        'ClasseE',
        'C3',
        'RS',
        'Giuletta',
        'A4'
    ];
    const path = [
        '\\public\img\Golf.png',
        '\\public\img\Golf.png',
        '\\public\img\Golf.png',
        '\\public\img\Golf.png',
        '\\public\img\Golf.png',
        '\\public\img\A4.png'
    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::name as $Index => $ImageName) {
            $image = new Images();
            $image->setName($ImageName);
            $image->setPath((self::path[$Index]));

            /*if($Index == 3){
                dd($UserName.' '. self::Pass[$Index]);
            }*/

            $manager->persist($image);
        }
        $manager->flush();
    }
}
