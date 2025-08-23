<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Str;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentService
{
    // public function __construct()
    // {
    //     Stripe::setApiKey(config('services.stripe.secret'));
    // }

    // public function createPaymentIntent(float $amount, string $currency = 'usd')
    // {
    //     $amount_cents = intval($amount * 100);
    //     $paymentIntent = PaymentIntent::create([
    //         'amount' => $amount_cents,
    //         'currency' => $currency,
    //         'payment_method_types' => ['card'], 
    //         'description' => 'One-time payment',
    //         'metadata' => [
    //             'order_id' => Str::uuid(), 
    //         ],
    //     ]);
    //     return $paymentIntent;
    // }


    // public function recordPayment(array $data)
    // {
    //     return Payment::create([
    //         'method' => $data['method'] ?? 'stripe',
    //         'amount' => $data['amount'],
    //         'payment_date' => now(),
    //         'status' => $data['status'] ?? 'paid',
    //     ]);
    // }
}
