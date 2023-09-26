<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        /*for ($i = 0; $i < 5; $i++) {
            $contact = new Contact();
            $contact->setFullName($this->Faker->text());
        }*/
        $manager->flush();
    }
}
