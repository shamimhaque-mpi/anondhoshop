<?php

namespace App\Repositories;
use App\Models\Admin;
use App\Models\AdminInfo as Information;
use App\Interfaces\Image;
use App\Interfaces\Admin as AdminInter;
use Auth, DB;

class AdminInfo implements AdminInter
{
	protected $image;

	public function __construct(Images $image)
	{
		$this->image = $image;
	}

	// Get Admin Information
	public function get()
	{
		$id = Auth::guard('admin')->user()->id;

		$AdminInfo = Information::where('admin_id', $id);

		if($AdminInfo->first())
		{
			$result = DB::table('admins')
		        ->join('admin_infos', 'admins.id', '=', 'admin_infos.admin_id')
		        ->select('admins.name','admins.email', 'admins.photo', 'admins.username', 'admins.mobile', 'admin_infos.*')
		        ->where('admins.id', $id)->first();
		}
		else
		{
			$result = Admin::where('id', $id)->first();
		}

        

		return $result;
		// return Admin::where('id',)->with(['adminInfo'])->first();
	}
	//Image Upload
	public function image($file)
	{
		$id = Auth::guard('admin')->user()->id;
		$admin = Admin::where('id', $id);
		$this->image->delete($admin->first()->photo);

		$new_path = $this->image->image($file)->resize(300)->save('public/backend/images/admins', time(), 60);

        $admin->update(['photo'=>$new_path]);
        return $new_path;
	}
	public function update($request)
	{
		$data = $request->except(['mobile', 'email', 'name']);
		$id = Auth::guard('admin')->user()->id;
		//update Admin table
		Admin::where('id', $id)->update(['mobile'=>$request->mobile, 'email'=>$request->email, 'name'=>$request->name]);
		// Fetch Admin information Object
		$AdminInfo = Information::where('admin_id', $id);

		if($AdminInfo->first())
		{
			$AdminInfo->update($data);
		}
		else
		{	$data['admin_id'] = $id;
			$AdminInfo->create($data);
		}

		return json_encode(['name'=>$request->name]);
	}



}