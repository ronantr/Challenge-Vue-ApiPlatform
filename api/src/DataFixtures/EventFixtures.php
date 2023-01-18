<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\TheaterGroup;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // get all theatergroups 
        $theatergroups = $manager->getRepository(TheaterGroup::class)->findAll();
        $tickets = $manager->getRepository(Ticket::class)->findAll();
        
        $event = new Event();
        $event
        ->setName("Event 1")
        ->setDate(new \DateTime("2021-01-01"))
        ->setLocation("Event 1 Location")
        ->setDescription("Event 1 Description")
        ->setImage("Event 1 Image")
        ->setVideo("Event 1 Video")
        ->setCapacity(100);
        if (!empty($theatergroups)) {
            $event->setTheaterGroup($theatergroups[array_rand($theatergroups)]);
        }
        
        if (!empty($tickets)) {
            $event->setTicket($tickets[array_rand($tickets)]);
        }
        
        $manager->persist($event);
        $this->addReference('event', $event);
        $manager->flush();
            
    }
}
