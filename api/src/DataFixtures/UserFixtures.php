<?php

namespace App\DataFixtures;

use App\Entity\Level;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //get levelNumber 1
        dd($level = $manager->getRepository(Level::class)->findOneByLevelNumber(1));
        
        $password = '$2y$13$DaS5Nr.ER6ajgZhBVqNqm.wO8gqLyqEDvrTbHZiLCA5oYJE099NfO';
        $faker = Factory::create('fr_FR');
        $admin = new User();
        $admin
            ->setEmail('admin@test.fr')
            ->setFirstname("admin")
            ->setLastname("admin")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($password)
            ->setCredit(0)
            ->setPoints(0)
            ->setIsVerified(true);

        $manager->persist($admin);

        $user = (new User())
            ->setEmail("user@test.fr")
            ->setFirstname("user")
            ->setLastname("user")
            ->setRoles(['ROLE_USER'])
            ->setPassword($password)
            ->setCredit(0)
            ->setPoints(0)
            ->setLevel($manager->getRepository(Level::class)->findOneByLevelNumber(1))
            ->setIsVerified(true);

        $manager->persist($user);

        $theater = new User();

        $theater
            ->setEmail("theater@test.fr")
            ->setFirstname("theater")
            ->setLastname("theater")
            ->setRoles(['ROLE_THEATER'])
            ->setTheaterGroupEmail($faker->email)
            ->setTheaterGroupName($faker->company)
            ->setPassword($password)
            ->setCredit(0)
            ->setPoints(0)
            ->setIsVerified(true);

        $manager->persist($theater);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LevelFixtures::class,
        ];
    }
}
