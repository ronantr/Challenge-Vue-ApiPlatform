<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\TheaterGroup;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class TheaterGroupFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create('fr_FR');
    $user = $this->getReference('user');

    $theaterGroup = new TheaterGroup();

    $theaterGroup
      ->setName($faker->word)
      ->setPhoneNumber($faker->phoneNumber)
      ->setRepresentative($user)
      ->setStatus("pending");

    $manager->persist($theaterGroup);

    for ($i = 0; $i < 10; $i++) {
      $user = $this->getReference('user_' . $i);
      $theaterGroup = new TheaterGroup();

      $theaterGroup
        ->setName($faker->word)
        ->setPhoneNumber($faker->phoneNumber)
        ->setRepresentative($user)
        ->setStatus("pending");

      $this->addReference('theaterGroup_' . $i, $theaterGroup);

      $manager->persist($theaterGroup);
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