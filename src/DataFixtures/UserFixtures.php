<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    const Users = [
        'John',
        'Kath',
        'Aziz',
        'Vlad',
    ];
    const Pass = [
        'America!',
        'Deutschland!',
        'Allah!',
        'Russia!',
    ];
    const Names = [
        'John Doe',
        'Katherine Neu',
        'Aziz Abdoul',
        'Vladmir Poutine',
    ];

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        /*$this->factory = new PasswordHasherFactory([
        'common' => ['algorithm' => 'bcrypt'],
        'sodium' => ['algorithm' => "sodium"],
        ]);*/
    }

    public function load(ObjectManager $manager): void
    {

        foreach (self::Users as $Index => $UserName){
            $user = new User();
            $user->setUsername($UserName);

            $password = $this->hasher->hashPassword($user,self::Pass[$Index]);
            $user->setPassword($password);
            $user->SetName(self::Names[$Index]);
            /*if($Index == 3){
                dd($UserName.' '. self::Pass[$Index]);
            }*/

            $manager->persist($user);
        }

        //$manager->persist($user);
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);
        /*
        $user = new User(); //Pensez bien à ajouter le use App\Entity\User en haut du fichier !
        $user->setUsername('John');
        */
        //$this->hashPassword->$user->setPassword('test');
        //$hasher = $this->factory->getPasswordHasher('common');
        /*
        $password = $this->hasher->hashPassword($user,'test');
        $user->setPassword($password);
        $user->setName("John Doe");
        $manager->persist($user);
        $manager->flush();
        */
    }
}
/*
 * Hashing a Stand-Alone String
The password hasher can be used to hash strings independently of users. By using the PasswordHasherFactory,
 you can declare multiple hashers, retrieve any of them with its name and create hashes.
 You can then verify that a string matches the given hash:
 * use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

// configure different hashers via the factory
$factory = new PasswordHasherFactory([
    'common' => ['algorithm' => 'bcrypt'],
    'sodium' => ['algorithm' => 'sodium'],
]);

// retrieve the hasher using bcrypt
$hasher = $factory->getPasswordHasher('common');
$hash = $hasher->hash('plain');

// verify that a given string matches the hash calculated above
$hasher->verify($hash, 'invalid'); // false
$hasher->verify($hash, 'plain'); // true
 */