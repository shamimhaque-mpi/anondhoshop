<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class RegistationController extends Controller
{
    public function __construct() 
    {
    	//
    }

    // Loginout
    public function logout() 
    {
    	Auth::guard('admin')->logout();
		return redirect()->route('admin.login');
    }
}
