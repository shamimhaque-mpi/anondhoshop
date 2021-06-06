<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use DB;
use App\Models\ProductColor;

class ShopController extends Controller
{
    function index($slug=null)
    {
        $slug_decode = json_decode(base64_decode($slug));
        $ids = '{}';
        if($slug_decode){
            foreach ($slug_decode as $key => $value) {
                $ids = json_encode($this->getIds($key, $value));
            }
        }
    	return view('frontend.pages.shop', compact('slug', 'ids'));
    }

    // Fetch Brand for Filter
    public function brand(Request $request, $skip=0, $take=5)
    {
    	$brands = new Models('Brand');
        if($request->brand_ids){
            foreach ($request->brand_ids as $value) {
               $brands = $brands->orWhere(['id'=>$value]); 
            }
        }

    	$brands = $brands->skip($skip)->take($take)->select(['id', 'name'])->get();
    	return response()->json($brands);
    }

    // Fetch Color for Filter
    public function color(Request $request, $skip=0, $take=5){
    	$colors = new Models('Color');
        if($request->color_ids){
            foreach ($request->color_ids as $value) {
               $colors = $colors->orWhere(['id'=>$value]); 
            }
        }
    	$colors = $colors->skip($skip)->take($take)->select(['id', 'name'])->get();
    	return response()->json($colors);
    }

    // Fetch Size for Filter
    public function size(Request $request, $skip=0, $take=5){
    	$sizes = new Models('Size');
        if($request->size_ids){
            foreach ($request->size_ids as $value) {
                $sizes = $sizes->orWhere(['id'=>$value]);
            }
        // return response()->json($value);
        }
    	$sizes = $sizes->skip($skip)->take($take)->select(['id', 'name'])->get();
    	return response()->json($sizes);
    }

    // Fetch Unit for Filter
    public function unit(Request $request, $skip=0, $take=5){
    	$units = new Models('Unit');
        if($request->unit_ids){
            foreach ($request->unit_ids as $value) {
                $units = $units->orWhere(['id'=>$value]);
            }
        }
    	$units = $units->skip($skip)->take($take)->select(['id', 'name'])->get();
    	return response()->json($units);
    }

    /*
     * ***************************
     * Search Limited Product
     * And Show in Show Page
     * ***********************
    */
    public function product(Request $request, $skip=0, $take=25){
    	$products = DB::table('products')
        ->join('images', 'products.id', '=', 'images.product_id')


        ->leftjoin('product_sizes', 'product_sizes.product_id',     '=', 'products.id')
        ->leftjoin('sizes',         'sizes.id',                     '=', 'product_sizes.size_id')

        ->leftjoin('product_colors','product_colors.product_id',    '=', 'products.id')
        ->leftjoin('colors',        'colors.id',                    '=', 'product_colors.color_id')

        ->select('products.*', 'images.medium as image', 'sizes.name as size_name', 'colors.name as color_name')
        ->groupBy('products.id')
        ->get();

        if($request->category)
        {
            
        }

    	

    	return response()->json($products);
    }


    /*
     * ********************************
     * Get All Id Of Color, Size
     * Brand, Unit. Which is The
     * Id Found in The Searching
     * Product
     * *******************************
    */
    private function getIds($key, $value)
    {
        $products = [];

        if($key=='category'){
            $catProduct = new Models('CategoryProduct');
            $products = $catProduct->where(['category_id'=>$value])->with(['shop'])->get();
        }
        else if($key=='subcategory'){
            $subcatProduct = new Models('ProductSubCategory');
            $products = $subcatProduct->where(['sub_category_id'=>$value])->with(['shop'])->get();
        }
        else if($key=='subsubcategory'){
            $subsubcatProduct = new Models('ProductSubSubCategory');
            $products = $subsubcatProduct->where(['sub_sub_category_id'=>$value])->with(['shop'])->get();
        }

        $ids = [
            'brand' =>[],
            'unit'  =>[],
            'color' =>[],
            'size'  =>[],
            $key    =>$value,
        ];
        foreach ($products as $key => $value) {
            // Retrive Brand Id
            if(!in_array($value->shop->brand_id, $ids['brand'])){
                array_push($ids['brand'], $value->shop->brand_id);
            }
            // Retrive Unit Id
            if(!in_array($value->shop->unit_id, $ids['unit'])){
                array_push($ids['unit'], $value->shop->unit_id);
            }
            // Retrive Color Id
            if($value->shop->color){
                foreach ($value->shop->color as $color) {
                    if(!in_array($color->id, $ids['color'])){
                        array_push($ids['color'], $color->id);
                    }
                }
            }
            // Retrive Size id
            if($value->shop->size){
                foreach ($value->shop->size as $size) {
                    if(!in_array($size->id, $ids['size'])){
                        array_push($ids['size'], $size->id);
                    }
                }
            }
        }
        return $ids;
    }

    // Get Searching key
    public function searchingKey(Request $request){
        $data = $request->all();
        foreach ($data as $key => $value) {
            $object     = false;
            $key_name   = '';

            if($key=='category')
            {
                $object     = new Models('Category');
                $key_name   = 'Category';
            }
            else if($key=='subcategory')
            {
                $object     = new Models('SubCategory');
                $key_name   = 'Sub Category';
            }
            else if($key=='subsubcategory')
            {
                $object     = new Models('SubSubCategory');
                $key_name   = 'Sub Sub Category';
            }
            if($object){
                $object = $object->where(['id'=>$value]);
                return response()->json([
                    'key_name'  => $key_name,
                    'key'       => $object->first()->name,
                ]);
            }
        }
    }

    public function productFilter(Request $request)
    {
        $where_condition = $request->all();
        // return json_encode($where_condition);
        $products = DB::table('products')

        ->leftjoin('brands', 'brands.id',         '=', 'products.brand_id')
        ->leftjoin('units',  'units.id',          '=', 'products.unit_id')
        ->leftjoin('images', 'images.product_id', '=', 'products.id')

        ->leftjoin('product_sizes', 'product_sizes.product_id', '=', 'products.id')
        ->leftjoin('sizes',         'sizes.id',                 '=', 'product_sizes.size_id')

        ->leftjoin('product_colors','product_colors.product_id', '=', 'products.id')
        ->leftjoin('colors',        'colors.id',                 '=', 'product_colors.color_id');

        
        foreach ($where_condition as $key => $value) {
            if(is_array($value)){
                foreach ($value as $index=>$order) {
                    if($key=='min'){
                        if($index==0){
                            $products = $products
                            ->where([['products.present_sale_price', '>=', $order]]); 
                        }
                    }
                    else if($key=='max'){
                        if($index==0){
                            $products = $products
                            ->where([['products.present_sale_price', '<=', $order]]); 
                        }
                    }
                    else if($key=='sort'){
                        $products = $products
                        ->orderBy('products.present_sale_price', $order); 
                    }
                }
            }
            else if($key=='size' && count($value) > 0){
                $products = $products->whereIn('sizes.id', $value);
            }
            else if($key=='brand' && count($value) > 0){
                $products = $products->whereIn('brands.id', $value);
            }
            else if($key=='unit' && count($value) > 0){
                $products = $products->whereIn('units.id', $value); 
            }
            else if($key=='color' && count($value) > 0){
                $products = $products->whereIn('colors.id', $value);
            }
            else if($key=='category' && $value!=null){
                $products = $products
                ->join('category_products', 'category_products.product_id',  '=', 'products.id')
                ->join('categories', 'categories.id', '=', 'category_products.category_id')
                ->where('categories.id', $value); 
            }
            else if($key=='subcategory' && $value!=''){
                $products = $products
                ->join('product_sub_categories', 'product_sub_categories.product_id', '=', 'products.id')
                ->join('sub_categories', 'sub_categories.id', '=', 'product_sub_categories.sub_category_id')
                ->where('sub_categories.id', $value); 
            }
            else if($key=='subsubcategory' && $value!=''){
                $products = $products
                ->join('product_sub_sub_categories', 'product_sub_sub_categories.product_id', '=', 'products.id')
                ->join('sub_sub_categories', 'sub_sub_categories.id', '=', 'product_sub_sub_categories.sub_sub_category_id')
                ->where('sub_sub_categories.id', $value); 
            }
        }
        
        $products = $products->select('products.*', 'sizes.name as size_name', 'colors.name as color_name', 'images.small as image')->groupBy('products.id');
        return response()->json($products->get());
    }


    // Quick Product view
    public function quickView(Request $request)
    {
        $product_id = $request->id;

        $product = DB::table('products')
                ->join('units', 'products.unit_id', '=', 'units.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')

                ->leftjoin('product_sizes', 'product_sizes.product_id', '=', 'products.id')
                ->leftjoin('sizes',         'sizes.id',                 '=', 'product_sizes.size_id')

                ->leftjoin('product_colors','product_colors.product_id', '=', 'products.id')
                ->leftjoin('colors',        'colors.id',                 '=', 'product_colors.color_id')

                ->select('products.id', 'products.name', 'products.regular_price', 'products.present_sale_price', 'products.min_sale_quantity', 'brands.name as brand', 'units.name as unit', 'colors.name as color_name', 'sizes.name as size_name')
                ->where(['products.id'=>$product_id])->first();

        $colors = DB::table('product_colors')
                ->join('colors', 'product_colors.color_id', '=', 'colors.id')
                ->select('colors.id', 'colors.name')
                ->where(['product_colors.product_id'=>$product_id])->get();

        $sizes = DB::table('product_sizes')
                ->join('sizes', 'product_sizes.size_id', '=', 'sizes.id')
                ->select('sizes.id', 'sizes.name')
                ->where(['product_sizes.product_id'=>$product_id])->get();

        $images = DB::table('images')
                ->select('large', 'smaller', 'color_id', 'size_id')
                ->where(['product_id'=>$product_id])->get();

        $packet = [
            'product'   => $product,
            'colors'    => $colors,
            'sizes'     => $sizes,
            'images'    => $images,
        ];

        return response()->json($packet);
    }

    // Search Query
    public function search(Request $request){
        $result = [];

        if($request->isMethod('POST') && $request->key != '')
        {
            $key = $request->key;
            $result = DB::table('products')
            ->join('images', 'images.product_id', '=', 'products.id')
            ->leftjoin('category_products', 'category_products.product_id', '=', 'products.id')
            ->leftjoin('categories', 'categories.id', '=', 'category_products.category_id')
            ->select('products.id', 'products.name as name', 'categories.name as cat_name', 'images.smaller as img')
            ->groupBy('products.id')
            ->where('products.name', 'LIKE', '%'.$key.'%');

            $result = [
                'total' => $result->get()->count(),
                'items' => $result->take(5)->get(),
            ];
        }
        return response()->json($result);
    }

}
