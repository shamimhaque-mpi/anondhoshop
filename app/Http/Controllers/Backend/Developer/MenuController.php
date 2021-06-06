<?php

namespace App\Http\Controllers\Backend\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Privilege;
use Auth;
use DB;

class MenuController extends Controller
{
	public function __construct()
	{
		//
	}

	// Get All Menu
    public function AllMenu() 
    {
		return Menu::where([
			['status', 1],
			['name_en', '!=', 'dashboard'],
		])->get();
    }

    // Get User Privilege
    public function UserPrivilege()
    {
    	return Privilege::where('user_id', Auth::guard('admin')->user()->id)
	    		->select('menu', 'sub_menu')
	    		->first();
    }
    // Get User Permited sub menu
    public function SubMenus()
    {
    	$where[] = ['sub_menus.route', Request()->route()->getName()];
    	$where[] = ['action_menus.status', 1];

    	$privilege = DB::table('privileges')->where('user_id', Auth::guard('admin')->user()->id)->first();
    	$permission = json_decode($privilege->action_menu ?? "");

    	$action_menus = DB::table('sub_menus')
	    	->join('action_menus', 'sub_menus.id', '=', 'action_menus.parent_id')
	    	->where($where)
	    	->select('action_menus.*')->get();

	    $per_action_menu = [];
	    foreach ($action_menus as $value) {
	    	if(in_array($value->id, ($permission ?? [])) || (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'developer'))
	    	$per_action_menu[] = (object)['name'=>strtolower($value->name_en),'name_locale'=>strtolower((\App::isLocale('en') ? $value->name_en : $value->name_bn)), 'icon'=>$value->icon, 'url'=>$value->url, 'route'=>$value->route];
	    }
	    return $per_action_menu;
    }
}
