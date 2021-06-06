<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use App\Repositories\Images;

class ServiceController extends Controller
{
	protected $service;
    function __construct() 
    {
        $this->service = new Models("OurService");
    }

    public function index(){
    	$allServices = $this->service->where(['trash'=>0])->orderBy('id', 'DESC')->get();
    	return view('backend.pages.services.index', compact('allServices'));
    }

    public function add(Request $request){
    	if($request->isMethod('POST')){
    		$this->store($request);
	    	return redirect()->route('admin.services.list');
    	}else{
	    	return view('backend.pages.services.add');
	    }
    }

    public function store($request){
    	$request->validate([
    		'title'			=> 'required',
    		'description'	=> 'required',
    		'img'			=> 'required'
    	]);
    	$img = new Images();
    	$data = $request->except(['_token', 'img']);
    	$data['img_small'] = $img->image($request->img)->resize(300, 300)->save('public/images/services/small', time());
    	$data['img_large'] = $img->image($request->img)->resize(700, 700)->save('public/images/services/large', time());
    	$this->service->create($data);
    	session()->flash('success', '✔ New Service Successfully Inserted');
    }
    public function edit(Request $request, $id){
        $service = $this->service->where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $this->update($request, $id, $service);
            session()->flash('success', 'Data Updated Successfully');
            return redirect()->route('admin.services.list');
        }
    	return view('backend.pages.services.edit', compact('service'));
    }
    protected function update(Request $request, $id, $service){
        $data = $request->except(['img', '_token']); 
        if($request->img){
            if(file_exists($service->img_small)){
                unlink($service->img_small);
                unlink($service->img_large);
            }
            $img = new Images();
            $data['img_small'] = $img->image($request->img)->resize(300, 300)->save('public/images/services/small', time());
            $data['img_large'] = $img->image($request->img)->resize(700, 700)->save('public/images/services/large', time());
        }
        $service_obj = new Models("OurService");
        $service_obj->where(['id'=>$id])->update($data);
        return true;
    }
    public function delete($id){
    	$service = $this->service->where(['id'=>$id]);
    	$img = $service->first()->img_small;
    	if(file_exists($img)){
    		unlink($img);
    	}
    	$service->delete(['file'=>'img_large']);
    	session()->flash('success', '✔ This Service Successfully Deleted');
    	return redirect()->back();
    }
}
