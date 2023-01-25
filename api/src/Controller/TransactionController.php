<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\StripeService;
use App\Service\UserLevelService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionController extends AbstractController
{
    private $stripeService;
    private $levelService;

    public function __construct(StripeService $stripeService, UserLevelService $levelService)
    {
        $this->stripeService = $stripeService;
        $this->levelService = $levelService;
    }

    public function postTransaction(Request $request, User $user)
    {
        $amount = $request->get('amount');
        $stripeToken = $request->get('stripe_token');

        try {
            // Stripe payment logic
            $this->stripeService->charge($amount * 100, $stripeToken);
            // Update user's points and level
            $this->levelService->updateUserLevel($user, $amount);
        } catch (\Exception $e) {
            // Log the error
            // ...
            throw new \Exception('An error occurred while processing the transaction');
        }

        return $this->json(['message' => 'Payment successful']);

    }
}
