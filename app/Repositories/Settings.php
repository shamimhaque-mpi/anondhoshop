<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Images;
use App\Interfaces\Setting as SettingInter;

/**
 *  All Setting Control from here
 */
class Settings implements SettingInter
{
	protected $image;

	public function __construct(Images $image)
	{
		$this->image = $image;
	}
	/*
	* =======================
	*  This Method Use Only
	*  HTTP Request
	*  On Post
	* =================
	*/
	public function createOrUpdate($request)
	{
		$setting = Setting::first();

    	if($setting)
    	{
    		if($request->type == 'fav_icon')
    		{
    			$this->image->delete($setting->fav_icon);
    			$path = $this->image->image($request->image)->resize(150)->save('public/backend/images/site/', time(), 30);

    			Setting::find($setting->id)->update(['fav_icon'=>$path]);
    			return $path;
    		}
    		else if($request->type == 'logo')
    		{
    			$this->image->delete($setting->logo);
    			$path = $this->image->image($request->image)->resize(400)->save('public/backend/images/site/', time(), 40);

    			Setting::find($setting->id)->update(['logo'=>$path]);
    			return $path;
    		}
    		else
    		{
    			$data = $request->except([]);
    			Setting::find($setting->id)->update($data);
    			return 1;
    		}
    	}else{
    		if($request->type == 'fav_icon')
    		{
    			$path = $this->image->image($request->image)->resize(150)->save('public/backend/images/site/', time(), 30);
    			Setting::create(['fav_icon'=>$path]);
    			return $path;
    		}
    		else if($request->type == 'logo')
    		{
    			$path = $this->image->image($request->image)->resize(400)->save('public/backend/images/site/', time(), 40);
    			Setting::create(['logo'=>$path]);
    			return $path;
    		}
    		else
    		{
    			$data = $request->except([]);
    			Setting::create($data);	
    			return 1;
    		}
    	}
    	return $request->image;
	}

	/*
	* =======================
	*  This Method Use Only
	*  HTTP Request
	*  On Post
	* =================
	*/
	public function get()
	{
		return Setting::first();
	}
}