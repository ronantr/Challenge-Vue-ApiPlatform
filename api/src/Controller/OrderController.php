<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Ticket;
use App\Entity\User;
use App\Service\StripeService;
use App\Service\UserLevelService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class OrderController extends AbstractController
{
    private $stripeService;
    private $security;
    private $em;

    public function __construct(StripeService $stripeService,Security $security,EntityManagerInterface $em)
    {
        $this->stripeService = $stripeService;
        $this->security = $security;
        $this->em = $em;
    }

    public function __invoke(Order $order)
    {
        $order->setStatus('success');
        $order->setDate(new \DateTime());
        $order->setCustomer($this->security->getUser());
            
        try {
            $charge=$this->stripeService->charge($order->getAmount(), $order->getToken());
            $order->setStatus($charge->status);
            $order->setAmount($charge->amount);

            foreach($order->getTickets() as $ticket){
                $event = $ticket->getEvent();
                // $ticket = new Ticket();
                $ticket->setEvent($event);
                $ticket->setPrice($event->getPriceInCents()* $ticket->getQuantity());
                $ticket->setStatus('success');
                $ticket->setQuantity($ticket->getQuantity());
                $event->setCapacity($event->getCapacity() - $ticket->getQuantity());
                $this->em->persist($ticket);
                $this->em->persist($event);
                $order->addTicket($ticket);
                
            }
            $this->em->persist($order);
            $this->em->flush();
            return $order;

        } catch (\Exception $e) {
            
            // Log the error
            // ...
            throw new \Exception($e->getMessage());
        }

}
    
    }

