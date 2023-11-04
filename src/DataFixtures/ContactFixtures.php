<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Offers;
use App\Repository\OffersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator as Faker;
use Faker\Factory;



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
