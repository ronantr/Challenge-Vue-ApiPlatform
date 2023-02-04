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

        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $amount =$faker->randomFloat(2, 1, 100);
            $user = $faker->randomElement($users);
            $bonus = 0;
            if($user->getLevel()!==null)
            {
                $bonus = $user->getLevel()->getBonusPercentage();
            }
            $bonusAmount = $amount * $bonus; 
            $object = (new Transaction())
                ->setAmount($amount)
                ->setDate($faker->dateTimeBetween('now', '+2 months'))
                ->setUser($user)
                ->setStatus($faker->randomElement(['reserved', 'failed', 'cancelled']))
                ->setBonusAmount($bonusAmount);
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
