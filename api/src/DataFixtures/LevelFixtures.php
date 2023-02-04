<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class LevelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $level1 = (new Level())
        ->setLevelNumber(1)
        ->setName("Level 1")
        ->setPointsRequired(100)
        ->setBonusPercentage(5);
        $manager->persist($level1);
    
        $level2 = (new Level())
        ->setLevelNumber(2)
        ->setName("Level 2")
        ->setPointsRequired(250)
        ->setBonusPercentage(10);
        $manager->persist($level2);

        $level3 = (new Level())
        ->setLevelNumber(3)
        ->setName("Level 3")
        ->setPointsRequired(500)
        ->setBonusPercentage(15);
        $manager->persist($level3);
    $manager->flush();

}
}
