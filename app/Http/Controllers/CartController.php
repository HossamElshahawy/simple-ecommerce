<?php

namespace App\Http\Controllers;

use App\Models\Product;


use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
    public function index(){



        return view('pages.cart')->with([
            "items" => CartFacade::getContent(),
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal'),
        ]);
    }


    public function addToCart(Request $request, Product $product)
    {

       $test = CartFacade::add([
            'id' => $product->id,
            'name' => $product->name,
            'image'=> $product->image,
            'price' => $product->price,
            'quantity' => 2,
            'associatedModel' => $product,
        ]);



        return redirect()->route('cart')->with('Add','Product Added Successfully');
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,' . $product->quantity
        ]);

        CartFacade::update($product->id, array(
            'quantity' => array(
                'relative' => false,
               'value' => $request->input('quantity'),
            )
        ));


        // Return the updated cart data as a JSON response
        return response()->json([
            'success' => true,

        ]);
    }

    public function empty(){
        CartFacade::destroy();
    }

    public function removeFromCart(Product $product_id)
    {
        CartFacade::remove($product_id);

        return response()->json(['success' => true,'message'=>'deleted success']);
    }

    public function getNumbers()
    {
        $tax = config('shopping_cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (CartFacade::getSubTotal() - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);

        return collect([
            'tax' => $tax,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
        ]);
    }
}
