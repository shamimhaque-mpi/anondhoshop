<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    protected $subcategory;

    function __construct() 
    {
        $this->subcategory = new Models("SubCategory");
    }

    // index
    public function index()
    {
        return view('backend.pages.subcategory.index');
    }

    // All
    public function all()
    { 
        $subcategories = $this->subcategory->orderBy('id', 'DESC')->with(['category'])->get()->toArray();
        return response()->json($subcategories, 200);
    }

    // store
    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $this->subcategory->create($data, ['file'=>'image', 'size'=>[300, 300], 'quality'=>50, 'location'=>'public/images/subcategory', 'slug'=>'name']);

        $result = $this->subcategory->orderBy('id', 'DESC')->with(['category'])->get()->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, $id)
    {
        if($request->image){
            $data = $request->except(['_token']);
            $this->subcategory->find(['id'=>$id])->update($data, ['file'=>'image', 'size'=>[300, 300], 'location'=>'public/images/subcategory']);
        }
        else{
            $data = $request->except(['_token', 'image']);
            $this->subcategory->find(['id'=>$id])->update($data);
        }
        $result = new Models('SubCategory');
        $result = $result->orderBy('id', 'DESC')->with(['category'])->get()->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete($id)
    {
        $this->subcategory->find(['id'=>$id])->delete(['file'=>'image']);
        $result = new Models('SubCategory');
        $result = $result->orderBy('id', 'DESC')->with(['category'])->get()->toArray();
        return response()->json($result, 200);
    }
}
