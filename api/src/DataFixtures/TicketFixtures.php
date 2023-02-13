<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ticket;
use App\Entity\Event;
use App\Entity\Order;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $events = $manager->getRepository(Event::class)->findAll();
        $orders = $manager->getRepository(Order::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $event = $faker->randomElement($events);
            $object = (new Ticket())
                ->setEvent($event)
                ->setPrice($faker->randomFloat(2, 1, 100))
                ->setOrder($faker->randomElement($orders))
                ->setStatus($faker->randomElement(['reserved', 'failed', 'cancelled']))
                ->setQuantity($faker->randomNumber(1, 10));
            $manager->persist($object);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            EventFixtures::class,
            OrderFixtures::class,

        ];
    }
}
