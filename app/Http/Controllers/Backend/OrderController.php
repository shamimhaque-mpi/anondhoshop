<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function __construct(){

    }

    // index
    public function index(){
    	return view('backend.pages.order.index');
    }

    // Fetch All Orders
    public function allOrders(){
    	$orders = DB::table('orders')
    	->join('users', 'users.id', '=', 'orders.user_id')
    	->join('order_items', 'order_items.order_id', '=', 'orders.id')
    	->select('orders.*', 'users.name', DB::raw('count(order_items.id) as total_item'))
    	->groupBy('orders.id')
    	->get();
    	return response()->json($orders);
    }

    // Get order
    public function order(Request $request){
    	if($request->order_id){
    		$order = DB::table('orders')
	    	->where('orders.id', $request->order_id);

	    	$items = $order->join('order_items', 'order_items.order_id', '=', 'orders.id')
	    	->join('products', 'products.id', '=', 'order_items.product_id')
	    	->leftjoin('colors', 'colors.id', '=', 'order_items.color_id')
            ->leftjoin('sizes', 'sizes.id', '=', 'order_items.size_id')
	    	->select('order_items.*', 'products.name', 'colors.name as color', 'sizes.name as size')
	    	->groupBy('order_items.id')
	    	->get();

	    	$order_info = $order->join('users', 'users.id', '=', 'orders.user_id')
	    	->select('users.name', 'orders.*')->first();
	    	return response()->json([
	    		'items'		=>$items,
	    		'order_info'=>$order_info
	    	]);
    	}
    	return false;
    }

    // Change Order Status
    public function changeStatus(Request $request){
        if($request->item_id && $request->status && $request->order_id)
        {
            DB::table('order_items')->where('id', $request->item_id)->update(['status'=>$request->status]);

            $items      = DB::table('order_items')->where('order_id', $request->order_id)->get();
            $total_item = count($items);
            $pending    = $processing = $ready = $shipped = 0;

            foreach ($items->groupBy('status') as $key => $value) {
                if($key == 'pending')
                    $pending = count($value);
                else if($key == 'processing')
                    $processing = count($value);
                else if($key == 'ready')
                    $ready   = count($value);
                else if($key =='shipped')
                    $shipped = count($value);
            }

            $order_status = 'pending';
            if($pending > 0 && $pending==$total_item){
                $order_status = 'pending';
            }
            else if($pending == 0 && ($processing == $total_item || (($ready > 0  && $ready < $total_item ) || ($shipped > 0 && $shipped < $total_item)))){
                $order_status = 'processing';
            }
            if($pending == 0  && $processing == 0 && ($ready == $total_item || ($shipped > 0 && $shipped != $total_item))){
                $order_status = 'ready';
            }
            else if($pending == 0 && $processing == 0 && $ready == 0){
                $order_status = 'shipped';
            }

            DB::table('orders')->where(['id'=>$request->order_id])->update(['status'=>$order_status]);
            
            return $order_status;

        }
    }
}
