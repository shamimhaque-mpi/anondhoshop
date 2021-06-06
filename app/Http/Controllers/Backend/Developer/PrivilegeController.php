<?php

namespace App\Http\Controllers\Backend\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Privilege;
use App\Models\Admin;
use Auth;

class PrivilegeController extends Controller
{
  function __construct()
  {
    //
  }
  // Previlege
  public function previlege(Request $request) 
  {
    
    $admins = Admin::where('type', '!=', 'developer')->get();
    $menus  = Menu::where('name_en', '!=', 'dashboard')->get();

  	return view('backend.pages.admin.previlege', compact('menus', 'admins'));
  }

}
