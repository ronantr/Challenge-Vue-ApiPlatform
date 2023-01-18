<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // get all theatergroups 
        $customers = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 20; $i++) {

            $object = (new Order())
                ->setAmount($faker->randomFloat(2, 1, 100))
                ->setDate($faker->dateTimeBetween('now', '+2 months'))
                ->setCustomer($faker->randomElement($customers))
                ->setStatus($faker->randomElement(['reserved', 'failed', 'cancelled']));
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
