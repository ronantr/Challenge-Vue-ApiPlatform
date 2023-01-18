<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ticket;
use App\Entity\TheaterGroup;
use App\Entity\Event;
use App\Entity\User;

class TicketFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $events = $manager->getRepository(Event::class)->findAll();
        $theatergroups = $manager->getRepository(TheaterGroup::class)->findAll();
        $customer = $manager->getRepository(User::class)->findAll();


        for ($i = 1; $i <= 5; $i++) {
            $ticket = new Ticket();
            $ticket->setPrice(rand(10, 50));
            $ticket->addEvent($events[array_rand($events)]);
            $ticket->setTheaterGroup($theatergroups[array_rand($theatergroups)]);
            $ticket->setCustomer($customer[array_rand($customer)]);
            $status = rand(1, 3);
            if ($status === 1) {
                $ticket->setStatus("reserved");
            } elseif ($status === 2) {
                $ticket->setStatus("failed");
            } else {
                $ticket->setStatus("cancelled");
            }
            
            $manager->persist($ticket);
            
        }
        
        $manager->flush();
    }
}
