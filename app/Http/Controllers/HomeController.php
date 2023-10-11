<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $banners = Banner::all();
        $products = Product::limit(3)->get();
        return view('pages.home',compact('banners','products'));
    }
}
