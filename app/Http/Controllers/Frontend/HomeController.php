<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    // Show the Wepsite index home page.
    public function index()
    {
        $services = new Models('OurService');
        $services = $services->orderBy('id', 'DESC')->get()->take(3);
        return view('frontend.pages.index', compact('services'));
    }

    // Show the Wepsite index home page.
    public function productReview()
    {
        return view('frontend.pages.product_review');
    }

    // Method of Service
    public function ourServce(){
        return view('frontend.pages.our_service');
    }

    // Method of Contact
    public function contactUs (){
        return view('frontend.pages.contact_us');
    }

    // Method of About Us
    public function aboutUs(){
        return view('frontend.pages.about_us');
    }
}
