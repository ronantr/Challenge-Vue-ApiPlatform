<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\LevelRepository;
use App\Service\StripeService;
use App\Service\UserLevelService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends AbstractController
{
    private $stripeService;
    private $levelService;
    private $levelRepository;

    public function __construct(StripeService $stripeService, UserLevelService $levelService, LevelRepository $levelRepository)
    {
        $this->stripeService = $stripeService;
        $this->levelService = $levelService;
        $this->levelRepository = $levelRepository;
    }

    public function __invoke(Transaction $transaction)
    {
        $transaction->setStatus('success');
        $transaction->setDate(new \DateTime());

            $this->levelService->updateUserLevel($transaction->getUser(), $transaction->getAmount());
        
    
//         ob_start();
// dump($transaction);
// $content = ob_get_clean();
// $response = new Response($content);
// $response->headers->set('Content-Type', 'text/plain');
// return $response;

        // try {
        //     // Stripe payment logic
        //     $charge=$this->stripeService->charge($transaction->getAmount() * 100, $transaction->getToken());
        //     $transaction->setStatus($charge->status);
        //     // Update user's points and level
        //     $this->levelService->updateUserLevel($transaction->getUser(), $transaction->getAmount());
        // } catch (\Exception $e) {
        //     // Log the error
        //     // ...
        //     throw new \Exception('An error occurred while processing the transaction');
        // }
        return $transaction;
    }
}
