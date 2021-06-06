<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use App\Interfaces\Model;

class CategoryController extends Controller
{
    protected $category;

    function __construct() 
    {
        $this->category = new Models("Category");
    }

    // index
    public function index()
    {
        return view('backend.pages.category.index');
    }

    // All
    public function all(Model $mdl)
    { 
        $categories = $mdl->model('Category')->with(['sub_category'])->orderBy('id', 'DESC')->get(['id', 'name']);
        return response()->json($categories, 200);
    }
    // All Category with Image
    public function allImg(Model $mdl)
    { 
        $categories = $mdl->model('Category')->with(['sub_category'])->orderBy('id', 'DESC')->get(['id', 'name', 'image']);
        return response()->json($categories, 200);
    }

    // store
    public function store(Request $request, Model $mdl)
    {
        $data = $request->except(['_token']);
        $mdl->model('Category')->create($data, ['file'=>'image', 'size'=>[300, 300], 'quality'=>50, 'location'=>'public/images/category', 'slug'=>'name']);

        $result = $mdl->model('Category')->orderBy('id', 'DESC')->get(['id', 'name', 'image'])->toArray();
        return response()->json($result, 200);
    }

    // update
    public function update(Request $request, Model $mdl, $id)
    {
        if($request->image){
            $data = $request->except(['_token']);
            $mdl->model('Category')->find(['id'=>$id])->update($data, ['file'=>'image', 'size'=>[300, 300], 'location'=>'public/images/category']);
        }
        else{
            $data = $request->except(['_token', 'image']);
            $mdl->model('Category')->find(['id'=>$id])->update($data);
        }
        $result = new Models('Category');
        $result = $result->orderBy('id', 'DESC')->get(['id', 'name', 'image'])->toArray();
        return response()->json($result, 200);
    }

    // delete
    public function delete($id)
    {
        $this->category->find(['id'=>$id])->delete(['file'=>'image']);
        $result = new Models('Category');
        $result = $result->orderBy('id', 'DESC')->get()->toArray();
        return response()->json($result, 200);
    }
}
