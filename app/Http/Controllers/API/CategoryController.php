<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;

class CategoryController extends Controller
{
    protected $category;
    //
    public function __construct(){
        $this->category = new Models("Category");
    }
    /**
     * Fetch Category Data With Skip And Take
     *
     * @return \Illuminate\Http\Response
     */
    public function limit(Request $request)
    {
        if($request->isMethod('post')){
            $skip       = $request->start;
            $take       = $request->end;
            $categories = $this->category->select(['id', 'name', 'image', 'slug'])->skip($skip)->take($take)->get();
            return response()->json($categories, 200);
        }
        else{
            return 0;
        }
    }
}
