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

    public function __construct(StripeService $stripeService, UserLevelService $levelService)
    {
        $this->stripeService = $stripeService;
        $this->levelService = $levelService;
    }

    public function __invoke(Transaction $transaction)
    {
        $transaction->setStatus('success');
        $transaction->setDate(new \DateTime());
        
        try {
            // Stripe payment logic
            $charge=$this->stripeService->charge($transaction->getAmount() * 100, $transaction->getToken());
            $transaction->setStatus($charge->status);
            // Update user's points and level
            $this->levelService->updateUserLevel($transaction->getUser(), $transaction->getAmount());
            return $transaction;
        } catch (\Exception $e) {
            // Log the error
            // ...
            throw new \Exception('An error occurred while processing the transaction');
        }
    }
}
