<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
    	$this->middleware('guest')->except('logout');
    } 

    // Login form
    public function showForm(){
    	return view('frontend.auth.login_form');
    }

    // Registration
    public function registration(Request $request)
    {
    	$valid 		= User::where(['mobile'=>$request->mobile])->orWhere(['username'=>$request->mobile])->first();
    	$validation = false;
    	if(!$valid){
	    	$data = $request->except(['_token']);
	    	$data['password'] = Hash::make($request->password);
	    	$data['username'] = $request->mobile;
	    	User::create($data);
	    	$validation = true;
    	}
    	return response()->json($validation);
    }

    public function login(Request $request){
    	$valid = User::where(['mobile'=>$request->username])->orWhere(['username'=>$request->username])->first();
    	$validation = false;
    	if($valid && Auth::guard('web')->attempt($request->only('username', 'password'))){
			$validation = (Auth::guard('web')->user());
    	}
    	return response()->json($validation);
    }

    // Gaurd Logout
    public function logout(){
    	Auth::guard('web')->logout();
    	return redirect()->back();
    }
}
