<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\TheaterGroup;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TheaterGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {

            $object = (new TheaterGroup())
                ->setName($faker->name)
                ->setContactEmail($faker->email)
                ->setContactName($faker->name);

            $manager->persist($object);
        }
        $manager->flush();
    }
}
