<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class TransactionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $customers = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 20; $i++) {

            $object = (new Transaction())
                ->setAmount($faker->randomFloat(2, 1, 100))
                ->setDate($faker->dateTimeBetween('now', '+2 months'))
                ->setCustomers($faker->randomElement($customers))
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
