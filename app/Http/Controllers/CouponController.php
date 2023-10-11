<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coupon = Coupon::where('code',$request->coupon_code)->first();
        if (!$coupon){
            return redirect()->route('cart')->with('error','not valid coupon !');
        }
        session()->put('coupon',[
            'name' => $coupon->code,
            'discount' => $coupon->discount(CartFacade::getSubTotal()),
        ]);

        return redirect()->route('cart')->with('Add','Coupon Applied !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
       session()->forget('coupon');
        return redirect()->route('cart')->with('Add','Coupon Deleted !');

    }
}
