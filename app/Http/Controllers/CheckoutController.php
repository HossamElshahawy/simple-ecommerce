<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Exception\CardErrorException;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
class CheckoutController extends Controller
{

    public function index()
    {
        return view('pages.checkout');
    }

    public function store(CheckoutRequest $request)
    {
        $cart = new CartController();
        try {
            $charge = Stripe::charges()->create([
                'amount' => $cart->getNumbers()->get('newTotal') / 30,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
//                    'contents' => $contents,
//                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson(),
                ],
            ]);

            CartFacade::clear();
            session()->forget('coupon');
            return redirect()->route('confirmation.index')->with('Add', 'Thank you! Your payment has been successfully accepted!');

        } catch (CardErrorException $e) {
//            $this->addToOrdersTables($request, $e->getMessage());
            return back()->withErrors('error! ' . $e->getMessage());
        }


    }

    public function confirmation()
    {
        return view('confirmation');
    }


}
