<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    // Guard Login 
    public function login(Request $request)
    {
    	$request->validate([
    		'username' => 'required',
    		'password' => 'required|min:6',
    	]);
    	if(Auth::guard('admin')->attempt($request->only('username', 'password')))
    	{
    		return redirect(session()->get('_previous.url', route('admin.dashboard')));
    	}
    	else{
    		return redirect()->back()->withInput($request->only('username'));
    	}
    }

}
