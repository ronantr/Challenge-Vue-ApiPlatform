<?php

namespace App\DataFixtures;

use App\Entity\Joke;
use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $jokes = $manager->getRepository(Joke::class)->findAll();

        for ($i = 0; $i < 300; $i++) {
            $object = (new Rate())
                ->setStar($faker->numberBetween(1, 5))
                ->setJoke($faker->randomElement($jokes));
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            JokeFixtures::class,
        ];
    }
}
