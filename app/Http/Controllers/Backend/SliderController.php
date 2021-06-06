<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;

class SliderController extends Controller
{
    protected $slider;

    function __construct() 
    {
        $this->slider = new Models("Slider");
    }

    // index
    public function index()
    { 
        return view('backend.pages.slider.index');
    }

    // List of slider
    public function list()
    { 
        $sliders = $this->slider->get();
        return response()->json($sliders, 200);
    }

    // store
    public function store(Request $request)
    {
        $data   = $request->except(['_token']);
        $this->slider->create($data, ['file'=>'img', 'size'=>[1600, 550], 'quality'=>60, 'location'=>'public/images/slider']);

        $result = $this->slider->get();
        return response()->json($result, 200);
    }

    // edit
    public function edit($id)
    {
        $slider = $this->slider->find(['id'=>$id])->first();
        return view('backend.pages.slider.edit', compact('slider'));
    }

    // update
    public function update(Request $request, $id)
    {
        if($request->img)
        {
	        $data = $request->except(['_token']);
	        $this->slider->find(['id'=>$id])->update($data, ['file'=>'img', 'size'=>[1600, 550], 'quality'=>60, 'location'=>'public/images/slider']);
        }
        else{
        	$data = $request->except(['_token', 'img']);
        	$this->slider->find(['id'=>$id])->update($data);
        }
		$result = new Models("Slider");
        return response()->json($result->get(), 200);
    }

    // delete
    public function delete($id)
    {
        $this->slider->find(['id'=>$id])->delete(['file'=>'img']);

        $result = new Models("Slider");
        return response()->json($result->get(), 200);
    }
}
