<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(){
    	$this->middleware('user')->except(['index']);
    }

    // Index 
    public function index(){
    	return view('frontend.pages.user.cart');
    }
    //Checkout
    public function checkout(){
        return view('frontend.pages.user.cart');
    }
}
