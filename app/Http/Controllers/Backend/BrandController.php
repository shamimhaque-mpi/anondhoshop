<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use App\Interfaces\Model;

class BrandController extends Controller
{
    protected $brand;

    function __construct() 
    {
        $this->brand = new Models("Brand");
    }

    // index
    public function index()
    {
        return view('backend.pages.brand.index');
    }

    // All
    public function all(Model $mdl)
    { 
        $brands = $mdl->model('Brand')->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($brands, 200);
    }

    // store
    public function store(Request $request, Model $mdl)
    {
        $data = $request->except(['_token']);
        $mdl->model('Brand')->create($data, ['file'=>'image', 'size'=>[300, 300], 'quality'=>50, 'location'=>'public/images/brand', 'slug'=>'name']);

        $result = $mdl->model('Brand')->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, Model $mdl, $id)
    {
        if($request->image){
            $data = $request->except(['_token']);
            $mdl->model('Brand')->find(['id'=>$id])->update($data, ['file'=>'image', 'size'=>[300, 300], 'location'=>'public/images/brand']);
        }
        else{
            $data = $request->except(['_token', 'image']);
            $mdl->model('Brand')->find(['id'=>$id])->update($data);
        }
        
        $result = new Models('Brand');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete(Model $mdl,$id)
    {
        $this->brand->find(['id'=>$id])->delete(['file'=>'image']);
        $result = new Models('Brand');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }
}
