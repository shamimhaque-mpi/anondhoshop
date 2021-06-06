<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
    	$this->middleware('user');
    }

    // User Dashboard
    public function index(){
    	return view('frontend.pages.user.index');
    }
}
