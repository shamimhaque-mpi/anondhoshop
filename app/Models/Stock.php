<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['product_id', 'stock_quantity', 'sale_quantity', 'current_quantity'];
}
