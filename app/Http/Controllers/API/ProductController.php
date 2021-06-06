<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use DB;

class ProductController extends Controller
{
    protected $product;
    //
    public function __construct(){
        $this->product = new Models("Product");
    }
    /**
     * Fetch Category Data With Skip And Take
     *
     * @return \Illuminate\Http\Response
     */
    public function limit(Request $request)
    {
        if($request->isMethod('post')){
            $products = DB::table('products')
            ->join('images', 'products.id', '=', 'images.product_id')


            ->leftjoin('product_sizes', 'product_sizes.product_id',     '=', 'products.id')
            ->leftjoin('sizes',         'sizes.id',                     '=', 'product_sizes.size_id')

            ->leftjoin('product_colors','product_colors.product_id',    '=', 'products.id')
            ->leftjoin('colors',        'colors.id',                    '=', 'product_colors.color_id')

            ->select('products.*', 'images.medium as image', 'sizes.name as size_name', 'colors.name as color_name')
            ->groupBy('products.id')
            ->get();
            return response()->json($products, 200);
        }
        else{
            return 0;
        }
    }
}
