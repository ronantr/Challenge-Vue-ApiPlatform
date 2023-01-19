<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\TheaterGroup;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // get all theatergroups 
        $theatergroups = $manager->getRepository(TheaterGroup::class)->findAll();
        $tickets = $manager->getRepository(Ticket::class)->findAll();

        for ($i = 0; $i < 10; $i++) {

            $object = (new Event())
                ->setName($faker->word)
                ->setDate($faker->dateTimeBetween('now', '+2 months'))
                ->setLocation($faker->address)
                ->setDescription($faker->text)
                ->setImage($faker->imageUrl())
                ->setVideo($faker->url)
                ->setCapacity(rand(50, 200))
                ->setTicket($faker->randomElement($tickets))
                ->setTheaterGroup($faker->randomElement($theatergroups));
            $manager->persist($object);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            TheaterGroupFixtures::class,
            UserFixtures::class,
        ];
    }
}
