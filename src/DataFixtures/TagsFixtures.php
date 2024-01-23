<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagsFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $tag = new Tags();
            // Utiliser Faker pour générer un nom de tag
            $tag->setTitle($this->faker->word);

            // Persister l'entité
            $manager->persist($tag);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['tags'];
    }
}
