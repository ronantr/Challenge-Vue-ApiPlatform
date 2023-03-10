<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Level;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $level = $manager->getRepository(Level::class)->findOneByLevelNumber(1);
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

        $this->addReference('admin', $admin);

        $manager->persist($admin);

        $user = (new User())
            ->setEmail("user@test.fr")
            ->setFirstname("user")
            ->setLastname("user")
            ->setRoles(['ROLE_USER'])
            ->setPassword($password)
            ->setCredit(0)
            ->setPoints(0)
            ->setLevel($level)
            ->setIsVerified(true);

        $this->addReference('user', $user);

        $manager->persist($user);

        for ($i = 0; $i < 1000; $i++) {
            $user = (new User())
                ->setEmail($faker->email)
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setRoles(['ROLE_USER'])
                ->setPassword($password)
                ->setCredit(0)
                ->setPoints(0)
                ->setLevel($level)
                ->setIsVerified(true);

            $this->addReference('user_' . $i, $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LevelFixtures::class,
        ];
    }
}
