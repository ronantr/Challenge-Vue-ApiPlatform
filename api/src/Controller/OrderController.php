<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Ticket;
use App\Entity\User;
use App\Service\StripeService;
use App\Service\UserLevelService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class OrderController extends AbstractController
{
    private $stripeService;
    private $security;

    public function __construct(StripeService $stripeService, UserLevelService $levelService, Security $security)
    {
        $this->stripeService = $stripeService;
        $this->security = $security;
    }

    public function __invoke(Order $order)
    {
        $order->setStatus('success');
        $order->setDate(new \DateTime());
        $order->setCustomer($this->security->getUser());
        
        try {
            // Stripe payment logic
            $charge=$this->stripeService->charge($order->getAmount() * 100, $order->getToken());
            $order->setStatus($charge->status);

            //for each item(item are events) in the order create a new ticket  
            
            foreach($order->getTickets() as $item){
                dd($item);
                $event = $item->getEvent();
                $ticket = new Ticket();
                $ticket->setEvent($event);
                $ticket->setQuantity($item->getQuantity());
                $order->addTicket($ticket);
                $event->setCapacity($event->getCapacity() - $item->getQuantity());

            }

            return $order;
        } catch (\Exception $e) {
            // Log the error
            // ...
            throw new \Exception('An error occurred while processing the transaction');
        }
    }
}
