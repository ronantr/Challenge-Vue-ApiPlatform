<?php

namespace App\DataFixtures;

use App\Entity\TheaterGroup;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $theaterGroups = $manager->getRepository(TheaterGroup::class)->findAll();
        $password = '$2y$13$DaS5Nr.ER6ajgZhBVqNqm.wO8gqLyqEDvrTbHZiLCA5oYJE099NfO';
        $faker = Factory::create('fr_FR');
        $admin = new User();

        $admin
            ->setEmail('admin@test.fr')
            ->setFirstname("admin")
            ->setLastname("admin")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($password)
            ->setCredit(0);

        $manager->persist($admin);

        $user = (new User())
            ->setEmail("user@test.fr")
            ->setFirstname("user")
            ->setLastname("user")
            ->setRoles(['ROLE_USER'])
            ->setPassword($password)
            ->setCredit(0);

        $manager->persist($user);

        $organisator = new User();

        $organisator
            ->setEmail("organisator@test.fr")
            ->setFirstname("organisator")
            ->setLastname("organisator")
            ->setRoles(['ROLE_ORGANISATOR'])
            ->setPassword($password)
            ->setCredit(0)
            ->setTheaterGroup($faker->randomElement($theaterGroups));

        $manager->persist($organisator);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TheaterGroupFixtures::class,
        ];
    }
}
