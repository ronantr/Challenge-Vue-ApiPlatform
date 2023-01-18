<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ticket;
use App\Entity\TheaterGroup;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // get all theatergroups 
        $customers = $manager->getRepository(User::class)->findAll();
        $events = $manager->getRepository(Event::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $event = $faker->randomElement($events);
            $object = (new Ticket())
                ->setCustomer($faker->randomElement($customers))
                ->setEvent($event)
                ->setPrice($faker->randomFloat(2, 1, 100))
                ->setStatus($faker->randomElement(['reserved', 'failed', 'cancelled']))
                ->setTheaterGroup($event->getTheaterGroup());
            $manager->persist($object);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            UserFixtures::class,
            EventFixtures::class,

        ];
    }
}
