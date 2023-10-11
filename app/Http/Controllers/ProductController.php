<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function singleProduct($slug){
        $product = Product::with('category')->where('slug',$slug)->firstOrFail();

        $mightAlsoLike = Product::with('category')->where('slug','!=',$slug)->inRandomOrder()->take(3)->get();

        return view('pages.single_product',compact('product','mightAlsoLike'));
    }
}
