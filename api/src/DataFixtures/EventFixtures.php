<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        //get all Users with role ROLE_THEATER
        $theaterGroup = $manager->getRepository(User::class)->findByRole('ROLE_THEATER');
        for ($i = 0; $i < 10; $i++) {

            $object = (new Event())
                ->setName($faker->word)
                ->setDate($faker->dateTimeBetween('now', '+2 months'))
                ->setLocation($faker->address)
                ->setDescription($faker->text)
                ->setImageName($faker->imageUrl())
                ->setVideoName($faker->url)
                ->setCapacity(rand(50, 200))
                ->setTheaterGroup($faker->randomElement($theaterGroup));
            $manager->persist($object);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
