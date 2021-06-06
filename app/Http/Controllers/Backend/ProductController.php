<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Product;
use App\Repositories\Models;

class ProductController extends Controller
{
    protected $product;
    function __construct() 
    {
        $product        = new Models('Product');
        $this->product  = $product->where(['trash'=>0]);
    }

    // index
    public function index()
    {
    	return view('backend.pages.product.list');
    }

    // index
    public function getAll()
    {
        $result = $this->product->orderBy('id', 'DESC')->with(['unit'])->get();
        return response()->json($result, 200);
    }

    //Single Product View
    public function view($id)
    {
        $result = $this->product->where(['id'=>$id]);

        if($result->exists())
        {
            $result = $result->with(['category', 'subcategory', 'subsubcategory', 'image', 'color', 'size'])->first();  
            return view('backend.pages.product.view', compact('result'));
        }
        return redirect()->route('admin.product.list');
    }

    // add
    public function add()
    {
    	return view('backend.pages.product.add');
    }

    // store
    public function store(Request $request, Product $product)
    {
        return $product->save($request);
    }

    // edit
    public function edit($id)
    {
    	return view('backend.pages.product.edit', compact('id'));
    }

    // Update
    public function update(Request $request, Product $product, $id)
    {
        // return $request->all();  
        return $product->update($request, $id);  
    }

    // Find Single Product
    public function find($id)
    {
       $result = $this->product->where(['id'=>$id]);

        if($result->exists())
        {
            $result = $result->with(['category_id', 'subcategory_id', 'subsubcategory_id', 'image', 'color_id', 'size_id'])->first();  
            return response()->json($result, 200);
        }
        else{
            return false;
        }
    }

    // delete
    public function trash(Request $request)
    {
        $this->product->find(['id'=>$request->id])->update(['trash'=>1]);
        $product = new Models('Product');
        $result = $product->orderBy('id', 'DESC')->where(['trash'=>0])->get();
        return response()->json($result, 200);
    }

    // delete
    public function imgDelete($id)
    {
        $imgObj = new Models('Image');
        $imgObj = $imgObj->where(['id'=>$id]);

        $img = $imgObj->first();
        if($img){
            $paths = [
                $img->large,
                $img->medium,
                $img->small,
                $img->smaller,
            ];
            foreach ($paths as $value) {
                if(file_exists($value)){
                    unlink($value);
                }
            }
        }
        $imgObj->delete();
        return true;
    }

    // delete
    public function delete()
    {
        return "delete";
    }
}
