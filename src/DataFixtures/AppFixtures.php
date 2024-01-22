<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private $passwordHasher;
    private $faker;


    public function __construct(
        UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        /**
         * Création d'un admin
         */
        $team = new Team();
        $team->setEmail('mickael.pol@web-atrio.com');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $team,
            'azerty'
        );
        $team->setPassword($hashedPassword)
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setFirstname('Mickael')
            ->setLastname('Pol');
        $manager->persist($team);
        $manager->flush();

        /**
         * Création d'utilisateur
         */
        for ($i = 1; $i <=3; $i++) {
            $user[$i] = (new User())
                ->setEmail('user' . $i . '@symfony.local')
                ->setFirstname($this->faker->firstName)
                ->setLastname($this->faker->lastName);
            $hashedPassword = $this->passwordHasher->hashPassword($user[$i], 'azerty');
            $user[$i]->setPassword($hashedPassword);
            $roles = ['ROLE_IDENTIFIED', 'ROLE_CUSTOMER', 'ROLE_ADMIN_CUSTOMER'];
            $role = array_rand(array_flip($roles), 1);
            $user[$i]->setRoles([$role]);
            $manager->persist($user[$i]);
        }
        $manager->flush();
    }
}
