<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use Auth;

class UserController extends Controller
{
    public function __construct(){
    	$this->middleware('user');
    }

    public function profileUpdate(Request $request){
    	$user = new Models('User');
    	if($request->img){
    		$user1 = $user->where(['id'=>Auth::guard('web')->user()->id]);
    		$user->where(['id'=>Auth::guard('web')->user()->id])->update(['img'=>$request->img], ['file'=>'img', 'location'=>'public/images/user/', 'size'=>[250, 250], 'quality'=>60]);
	    	return response()->json($user1->first()->img);
    	}
        else{
            $user1 = $user->where(['id'=>Auth::guard('web')->user()->id]);
            $user->where(['id'=>Auth::guard('web')->user()->id])->update($request->all());
            return response()->json($user1->first());
        }
    }

    public function getUserData(){
        return response()->json(Auth::guard('web')->user());
    }

    public function getDistricts(){
        $districts = new Models('District');
        return response()->json($districts->get());
    }

    public function getUpazilas(Request $request){
        if($request->district_id){
            $districts = new Models('Upazila');
            return response()->json($districts->where(['district_id'=>$request->district_id])->get());
        }
        return response()->json([]);
    }
}
