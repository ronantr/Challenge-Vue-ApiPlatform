<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\TheaterGroup;
use App\Entity\Event;
use App\Entity\Ticket;
use Doctrine\Persistence\ObjectManager;

class TheaterGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $events = $manager->getRepository(Event::class)->findAll();
        $tickets = $manager->getRepository(Ticket::class)->findAll();

        $manager->flush();
        $manager->clear();

        for ($i = 0; $i < 5; $i++) {
            $theatergroup = $manager->find(TheaterGroup::class, $i);
            if ($theatergroup) {
                $theatergroup
                    ->setName("TheaterGroup $i")
                    ->setContactName("TheaterGroup $i Contact Name")
                    ->setContactEmail("TheaterGroup $i Contact Email")
                    // associate a random event to the theatergroup
                    ->setTheaterGroup($events[array_rand($events)])
                    // associate a random ticket to the theatergroup
                    ->setTicket($tickets[array_rand($tickets)]);
                $manager->persist($theatergroup);
            }

        }

        $manager->flush();

    }
}
