<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create('fr_FR');

    for ($i = 0; $i < 20; $i++) {
      $event = new Event();
      $theaterGroup = $this->getReference('theaterGroup_' . $i);

      $event
        ->setName($faker->word)
        ->setDate($faker->dateTimeBetween('now', '+2 months'))
        ->setLocation($faker->address)
        ->setDescription($faker->text)
        ->setVideo($faker->url)
        ->setCapacity(rand(50, 200))
        ->setTheaterGroup($theaterGroup)
        ->setIsPublished($faker->boolean)
        ->setPriceInCents(rand(1000, 5000));

      $manager->persist($event);
    }
    
    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      TheaterGroupFixtures::class,
    ];
  }
}