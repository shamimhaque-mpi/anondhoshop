<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
 	protected $fillable = ['user_id', 'grand_total', 'shipping_charge', 'paid_amount', 'discount', 'coupon_discount', 'coupon_id', 'mobile', 'address', 'district_id', 'upazila_id', 'status'];   
}
