<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        // Admin
        $admin = (new User())
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN']);
        $adminPassword = $this->passwordHasher->hashPassword($admin, "admin");
        $admin->setPassword($adminPassword);
        $manager->persist($admin);

        // User
        $user = (new User())
            ->setEmail("user@test.com")
            ->setRoles(['ROLE_USER']);
        $userPassword = $this->passwordHasher->hashPassword($user, "user");
        $user->setPassword($userPassword);
        $manager->persist($user);

        // Moderator
        $moderator = (new User())
            ->setEmail("moderator@test.com")
            ->setRoles(['ROLE_MODERATOR']);
        $moderatorPassword = $this->passwordHasher->hashPassword($moderator, "moderator");
        $moderator->setPassword($moderatorPassword);
        $manager->persist($moderator);
        $manager->flush();
    }
}
