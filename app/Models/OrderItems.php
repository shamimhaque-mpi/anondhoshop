<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = ['order_id', 'product_id', 'sale_price', 'purchase_price', 'qty', 'discount', 'status', 'img', 'color_id', 'size_id'];
}
