<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use Auth, DB;

class WishListController extends Controller
{
	protected $wishlist;
    public function __construct(){
    	$this->middleware('user');
    	$this->wishlist = new Models('WishList');
    }

    // All Wishlist Of a User
    public function getWishList(){
    	$products = DB::table('wish_lists')
			->join('products', 'wish_lists.product_id', '=', 'products.id')
			->join('images', 'products.id', '=', 'images.product_id')
			->select('products.id','products.name', 'products.regular_price', 'products.present_sale_price as price', 'products.total_discount_persentige as discount', 'images.medium as img')
			->groupBy('products.id')
			->get();
    	return response()->json($products);
    }

    // Delete Product from Wishlist Of User
    public function deleteWishList(Request $request){
    	$where = [
    		'user_id' 	 => Auth::guard('web')->user()->id,
    		'product_id' => $request->product_id,
    	];
    	if($this->wishlist->where($where)->first()){
    		$this->wishlist->where($where)->delete();
    	}
    	$products = DB::table('wish_lists')
			->join('products', 'wish_lists.product_id', '=', 'products.id')
			->join('images', 'products.id', '=', 'images.product_id')
			->select('products.id','products.name', 'products.regular_price', 'products.present_sale_price as price', 'products.total_discount_persentige as discount', 'images.medium as img')
			->groupBy('products.id')
			->get();
    	return response()->json($products);
    }

    //Add To WishList
    public function addToWishList(Request $request)
    {
    	$data = [
    		'user_id' 	 => Auth::guard('web')->user()->id,
    		'product_id' => $request->product_id,
    	];
    	if($this->wishlist->where($data)->first()){
    		$this->wishlist->where($data)->delete();
    	}else{
    		$this->wishlist->create($data);
    	}
        return $this->wishListIds();
    }

    // Return Wish List Product ids
    public function wishListIds(){
        $wishlist    = new Models('WishList');
        $wishlist    = $wishlist->get(['product_id']);
        $product_ids = [];

        foreach ($wishlist as $key => $value) {
            $product_ids[] = $value->product_id;
        }
        return response()->json($product_ids);
    }
}
