<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Models;
use Illuminate\Http\Request;

class SubSubCategoryController extends Controller
{
    protected $subsubcategory;

    function __construct() 
    {
        $this->subsubcategory = new Models("SubSubCategory");
    }

    // index
    public function index()
    {
        return view('backend.pages.subsubcategory.index');
    }

    // All
    public function all()
    { 
        $subsubcategories = $this->subsubcategory->orderBy('id', 'DESC')->with(['sub_category'])->get()->toArray();
        return response()->json($subsubcategories, 200);
    }

    // store
    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $this->subsubcategory->create($data, ['file'=>'image', 'size'=>[300, 300], 'quality'=>50, 'location'=>'public/images/subsubcategory', 'slug'=>'name']);

        $result = $this->subsubcategory->orderBy('id', 'DESC')->with(['sub_category'])->get()->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, $id)
    {
        if($request->image){
            $data = $request->except(['_token']);
            $this->subsubcategory->find(['id'=>$id])->update($data, ['file'=>'image', 'size'=>[300, 300], 'location'=>'public/images/subsubcategory']);
        }
        else{
            $data = $request->except(['_token', 'image']);
            $this->subsubcategory->find(['id'=>$id])->update($data);
        }
        $result = new Models('SubSubCategory');
        $result = $result->orderBy('id', 'DESC')->with(['sub_category'])->get()->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete($id)
    {
        $this->subsubcategory->find(['id'=>$id])->delete(['file'=>'image']);
        $result = new Models('SubSubCategory');
        $result = $result->orderBy('id', 'DESC')->with(['sub_category'])->get()->toArray();
        return response()->json($result, 200);
    }
}
