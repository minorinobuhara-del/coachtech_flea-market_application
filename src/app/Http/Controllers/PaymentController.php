<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Item;

class PaymentController extends Controller
{
    public function create(Item $item)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $intent = PaymentIntent::create([
        'amount' => $item->price,
        'currency' => 'jpy',
        'metadata' => ['item_id' => $item->id,],
    ]);

    return view('payment.create', [
        'item' => $item,
        'clientSecret' => $intent->client_secret,
    ]);
}

}
