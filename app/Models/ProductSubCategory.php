<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $fillable = ['product_id', 'sub_category_id'];

    // Fetch All Product Reference by Sub Category
    public function shop(){
    	return $this->belongsTo(\App\Models\Product::class, 'product_id')->with(['brand', 'unit', 'category', 'subcategory', 'subsubcategory', 'color', 'size']);
    }
}
