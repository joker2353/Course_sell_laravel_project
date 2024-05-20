<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout(){
        Stripe::setApiKey(config('stripe.sk'));
         $session = Session::create([
             'line_items'  => [
                 [
                     'price_data' => [
                         'currency'     => 'gbp',
                         'product_data' => [
                             'name' => 'T-shirt',
                         ],
                         'unit_amount'  => 500,
                     ],
                     'quantity'   => 1,
                 ],
             ],
             'mode'        => 'payment',
             'success_url' => route('success'),
           
         ]);
 
         return redirect()->away($session->url);
 
         
 
 
     }
 
     public function success(){
         return view('welcome');
     }
}
