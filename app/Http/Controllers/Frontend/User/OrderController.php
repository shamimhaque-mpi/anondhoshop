<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Models;
use Auth, DB;

class OrderController extends Controller
{
    public function __construct(){
    	$this->middleware('user');
    }

    // Cart Submit
    public function makeOrder(Request $request)
    {
    	$order_info = [
    		'user_id' 	 		=> Auth::guard('web')->user()->id,
    		'address' 	 		=> $request->address,
    		'mobile'	 		=> $request->alt_mobile,
    		'district_id' 		=> $request->district_id,
    		'upazila_id' 		=> $request->upazila_id,
    		'shipping_charge'	=> 0,
    	];
    	$items = [];
		$grand_total = 0;
		// Get Items Of Voucher
    	if(is_array($request->cart)){
    		foreach($request->cart as $key=>$value){
    			$value = (Object)$value;
    			$grand_total += ($value->qty*$value->price);
				$items[$key]['product_id']	= $value->code;
                $items[$key]['color_id']    = $value->color_id ?? null;
                $items[$key]['size_id']     = $value->size_id ?? null;
				$items[$key]['qty']			= $value->qty;
				$items[$key]['sale_price']	= $value->price;
				$items[$key]['img']			= $value->img;
    		}	
    	}
    	$order_info['grand_total'] = $grand_total;
    	// Create A Order
    	$order_obj = new Models('Order');
    	$order = $order_obj->create($order_info);
    	// Create Order Items
    	if($order){
    		foreach ($items as $key => $value){
    			$value['order_id'] = $order->id;
    			$item_obj = new Models('OrderItems');
		    	$item_obj->create($value);
    		}
    	}
    	return response()->json($order);
    }

    // Fetch All User Order
    public function getAllOrder(){
        $order = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->groupBy('orders.id')
            ->select('orders.*', DB::raw('count(order_items.id) as total_item'))
            ->where('user_id', Auth::guard('web')->user()->id)
            ->get();
            return response()->json($order);
    } 

    // Fetch All User Order
    public function getOrder($order_id=null){
        if($order_id){
            $order = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftjoin('colors', 'colors.id', '=', 'order_items.color_id')
            ->leftjoin('sizes', 'sizes.id', '=', 'order_items.size_id')
            ->leftjoin('units', 'units.id', '=', 'products.unit_id')
            ->where('orders.user_id', Auth::guard('web')->user()->id)
            ->where('orders.id', $order_id)
            ->select('orders.*', 'order_items.*', 'products.name as title', 'colors.name as color', 'sizes.name as size', 'units.name as unit')
            ->groupBy('order_items.id')
            ->get();
            return response()->json($order);
        }
        else
        return 0;
    } 
}
