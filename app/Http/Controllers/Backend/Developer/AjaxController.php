<?php

namespace App\Http\Controllers\Backend\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privilege;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\ActionMenu;
use DB;

class AjaxController extends Controller
{
    public function __construct() 
    {
        //
    }
	// Fetch all menu submenu
    public function MenuSubmenu(Request $request)
    {
    	$result = [];
        //
    	if(Request()->menu_type == 'action_menu')
        {
            $result = DB::table('sub_menus')
            ->join('menus', 'sub_menus.parent_id', '=', 'menus.id')
            ->select('sub_menus.*', 'menus.name_en as parent_name')->get();
    	}
        //
    	else if(Request()->menu_type == 'sub_menu')
        {
    		$result = DB::table('menus')->where('name_en', '!=', 'dashboard')->get();
    	}

    	return response()->json(($result), 200);
    }
    // Fetch all menu submenu
    public function SigleMenu(Request $request)
    {
        $result = [];
        if(Request()->menu_type == 'sub_menu'){
            $result = SubMenu::where('id', Request()->id)->first();
        }
        else if(Request()->menu_type == 'menu'){
            $result = Menu::where('id', Request()->id)->first();
        }
        else if(Request()->menu_type == 'action_menu'){
            $result = ActionMenu::where('id', Request()->id)->first();
        }

        return response()->json(($result), 200);
    }

    // Menu Store
    public function MenuSubmenuStore(Request $request) 
    {
    	$result = '';
    	$data 	= $request->except(['menu_type', '_token']);
        $data['route'] = $request->route;

    	if($request->menu_type == "menu"){
    		unset($data['parent_id']);
    		Menu::create($data);
    		$result = 'menu';
    	}
    	if($request->menu_type == "sub_menu"){
    		SubMenu::create($data);
    		$result = 'sub_menu';
    	}
    	if($request->menu_type == "action_menu"){
    		ActionMenu::create($data);
    		$result = 'action_menu';
    	}
    	return $result;
    }

    // Menu Update
    public function MenuUpdate(Request $request) 
    {
        $result = '';
        $data   = $request->except(['previus_type', 'menu_type', '_token', 'id']);
        $data['route'] = $request->route;

        $position_change = ($request->previus_type == $request->menu_type);

        if($request->menu_type == "menu"){
            unset($data['parent_id']);
            if($position_change)
            {
                Menu::where('id', $request->id)->update($data);
            }else{
                $this->deleteAttribute($request->previus_type, $request->id); 
                Menu::create($data);
            }
            $result = 'menu';
        }
        if($request->menu_type == "sub_menu"){
            if($position_change)
            {
                SubMenu::where('id', $request->id)->update($data);
            }else{
                $this->deleteAttribute($request->previus_type, $request->id); 
                $data['parent_id'] = $request->parent_id;
                SubMenu::create($data);
            }
            $result = 'sub_menu';
        }
        if($request->menu_type == "action_menu"){
            if($position_change)
            {
                ActionMenu::where('id', $request->id)->update($data);
            }else{
                $this->deleteAttribute($request->previus_type, $request->id); 
                $data['parent_id'] = $request->parent_id;
                ActionMenu::create($data);
            }
            $result = 'action_menu';
        }
        return $result;
    }


    private function deleteAttribute($type, $id)
    {   $result = false;
        switch ($type) {
            case 'menu':
                $result = Menu::where('id', $id)->delete();
                break;

            case 'sub_menu':
                $result = SubMenu::where('id', $id)->delete();
                break;
                
            case 'action_menu':
                $result = ActionMenu::where('id', $id)->delete();
                break;
        }
        return $result;
    }



    // GET User Privilege
    public function getUserPrivilege($user_id)
    {
        $privilege = Privilege::where('user_id', $user_id)->first();
        
        if($privilege){
            $privilege = [

                'menu'           => json_decode($privilege ? $privilege->menu : '[]'),
                'sub_menu'       => json_decode($privilege ? $privilege->sub_menu : '[]'),
                'action_menu'    => json_decode($privilege ? $privilege->action_menu : '[]'),
            ];
        }

        return response()->json(($privilege ?? ''), 200);
    }

    // GET User Privilege
    public function setUserPrivilege(Request $request)
    {
        $data = [];
        if($request->isMethod('POST'))
        {

          $menu         = $request->menu ?? [];
          $sub_menu     = $request->sub_menu ?? [];
          $action_menu  = $request->action_menu ?? [];

          $data['menu']         = $menu;
          $data['sub_menu']     = $sub_menu;
          $data['action_menu']  = $action_menu;
          $data['user_id']      = $request->user_id;
          
          $message = Privilege::updateOrCreate(['user_id'=> $request->user_id], $data);
        }
        return response()->json(($message ?? ''), 200);
    }
}
