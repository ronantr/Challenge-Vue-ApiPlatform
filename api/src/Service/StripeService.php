<?php

namespace App\Service;

use Stripe\Stripe;

class StripeService
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = $_ENV['STRIPE_SECRET_KEY'];
    }

    public function charge(float $amount, string $token)
    {
        Stripe::setApiKey($this->secretKey);

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amount * 100,
                'currency' => 'eur',
                'source' => $token,
                'description' => 'Transaction for user'
            ]);
        } catch (\Stripe\Error\Card $e) {
            // Card error
            throw new \Exception($e->getMessage());
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            throw new \Exception($e->getMessage());
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            throw new \Exception($e->getMessage());
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            throw new \Exception($e->getMessage());
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            throw new \Exception($e->getMessage());
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user
            throw new \Exception($e->getMessage());
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            throw new \Exception($e->getMessage());
        }

        return $charge;
    }
}
