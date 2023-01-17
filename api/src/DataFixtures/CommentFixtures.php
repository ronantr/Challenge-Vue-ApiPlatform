<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Joke;
use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $jokes = $manager->getRepository(Joke::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $joke = $faker->randomElement($jokes);
            $object = (new Comment())
                ->setMessage($faker->paragraph)
                ->setJoke($joke);
            $manager->persist($object);

            $answer = (new Comment())
                ->setMessage($faker->paragraph)
                ->setJoke($joke)
                ->setAnswer($object);


            $manager->persist($answer);
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
