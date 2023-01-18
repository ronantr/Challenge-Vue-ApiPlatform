<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;
use App\Entity\User;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupère tous les utilisateurs de la base de données
        $users = $manager->getRepository(User::class)->findAll();

        // Boucle sur les utilisateurs pour créer des objets Order
        foreach ($users as $user) {
            $order = new Order();
            $order->setAmount(100);
            $order->setDate(new \DateTime());
            $status = mt_rand(0, 1) === 0 ? "success" : "failed";
            $order->setStatus($status);
            $order->setCustomer($user);

            $manager->persist($order);
        }

        $manager->flush();
    }
}
