<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{

    #[Route("users/{id}/payment/pay", name: "payment_pay", methods: ["POST"])]
    public function payAction(Request $request,$id,EntityManagerInterface $em, UserRepository $userRepository )
    {
        $stripe = new StripeClient($_ENV['STRIPE_SECRET_KEY']);
        $data = json_decode($request->getContent(), true);
        $amount = $data['amount'];
        $token = $data['token'];
        $user= $userRepository->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }
        try {
            $charge = $stripe->charges->create([
                'amount' => $amount*100,
                'currency' => 'EUR',
                'source' => $token,
                'description' => 'Payment for user '.$user->getId()
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            return $this->json(['error' => $e->getMessage()], 400);
        }
        catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly 
            return $this->json(['error' => $e->getMessage()], 400);
        
        } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Invalid parameters were supplied to Stripe's API
        return $this->json(['error' => $e->getMessage()], 400);
      } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
         return $this->json(['error' => $e->getMessage()], 400);
      }
        if($charge->status=='succeeded'){
            $user->setCredit($user->getCredit() + $amount);
            $em->persist($user);
            $em->flush();

            $transaction = new Transaction();
            $transaction->setUser($user);
            $transaction->setAmount($charge->amount);
            $transaction->setStatus($charge->status);

            $createdDate = new \DateTime();
            $createdDate->setTimestamp($charge->created);
            $transaction->setDate($createdDate);
            $em->persist($transaction);
            $em->flush();
            return $this->json(['message' => 'Payment successful']);
        }
        return $this->json(['error' => 'Payment failed']);
    }
}
