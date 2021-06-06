<?php
 use App\Models\Setting;
/**
 * Custom Helper
 */
if (!function_exists('SiteInfo')) 
{
	function SiteInfo ()
	{
		$fix = [
			'site_name'		=>'',
			'title_prefix'	=>'', 
			'mobile'		=>'', 
			'facebook'		=>'',
			'youtube'		=>'',
			'twitter'		=>'',
			'linkedin'		=>'',
			'mail'			=>'',
			'description'	=>'',
			'fav_icon'		=>'',
			'logo'			=>''
		];
		return (object)(Setting::first() ? Setting::first()->toArray() : $fix);
	}
}
if(!function_exists('action_menu')){
	function action_menu()
	{
		if(Auth::guard('admin')->check()){
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
}