<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //password = 'password'
        $password = '$2y$13$DaS5Nr.ER6ajgZhBVqNqm.wO8gqLyqEDvrTbHZiLCA5oYJE099NfO';

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

        $moderator = new User();

        $moderator
            ->setEmail("moderator@test.fr")
            ->setFirstname("moderator")
            ->setLastname("moderator")
            ->setRoles(['ROLE_MODERATOR'])
            ->setPassword($password)
            ->setCredit(0);

        $manager->persist($moderator);

        $manager->flush();
    }
}
