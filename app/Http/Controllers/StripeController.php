<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeController extends Controller
{
    
    
    public function checkout($price, $title) {
        Stripe::setApiKey(config('stripe.sk'));
    
        // Convert the price from string to integer (cents)
        $priceInCents = intval($price) ;
    
        $session = StripeSession::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $title,
                        ],
                        'unit_amount'  => $priceInCents,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            // 'cancel_url'  => route('cancel'), // Assuming you have a cancel route
        ]);
    
        return redirect()->away($session->url);
    }
 
     public function success(){
         return redirect()->route('account.enrollment');
     }
}
