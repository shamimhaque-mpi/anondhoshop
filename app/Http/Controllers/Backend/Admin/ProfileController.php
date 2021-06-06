<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Admin as Admins;
use App\Models\Admin;
use Auth, DB;

class ProfileController extends Controller
{
	protected $admin;
   	public function __construct(Admins $admin)
   	{
   		$this->middleware('admin');
   		$this->admin = $admin;
   	}

   	//Admin Profile
   	public function index()
   	{
   		// dd(Admin::where('id',Auth::guard('admin')->user()->id)->first()->with(['adminInfo']));
   		return view('backend.pages.profile');
   	}

   	/*
   	 * ========================
   	 *	Admin Fetch Profile
   	 * 	information with 
   	 * 	axios
   	 * ==================
   	*/
   	public function fetch()
   	{
   		return json_encode($this->admin->get());
   	}

   	/*
   	 * ========================
   	 *	Admin Profileupdate 
   	 * 	with axios
   	 * ==================
   	*/
   	public function update(Request $request)
   	{
   		if($request->photo)
         {
   			$path = $this->admin->image($request->photo);
   			return json_encode(['photo'=>$path]);
   		}
         else
         {  
   			return $this->admin->update($request);
   		}
   	}
}
