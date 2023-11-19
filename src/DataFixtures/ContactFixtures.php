<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;




class ContactFixtures extends Fixture //implements DependentFixtureInterface
{
    /*public function __constructor(OffersRepository $or) : void
    {
        $this->or = $or->findAll();
    }*/
    public function load(ObjectManager $manager): void
    {
        /*$contact = new Contacts();
        $faker = Factory::create();
        $contact->setEmail($faker->unique()->email);
        $contact->setSubject($faker->title);
        $contact->setCreatedAt(new \DateTimeImmutable());
        $contact->setMessage($faker->text());
        $contact->setOffer($this->getReference(Offers::class));
        */

        // $product = new Product();
        // $manager->persist($product);
        /*for ($i = 0; $i < 5; $i++) {
            $contact = new Contact();
            $contact->setFullName($this->Faker->text());
        }*/
        $manager->flush();
    }
   /* public function getDependencies()
    {
        return [
            OffersFixtures::class,
        ];
    }*/
}
