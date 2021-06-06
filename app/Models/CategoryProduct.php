<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $fillable = ['product_id', 'category_id'];

    // Fetch Products Reference By Category
    public function products(){
    	return $this->belongsTo(\App\Models\Product::class, 'product_id')->with(['brand']);
    }
    public function shop(){
    	return $this->belongsTo(\App\Models\Product::class, 'product_id')->with(['brand', 'unit', 'category', 'subcategory', 'subsubcategory', 'color', 'size']);
    }
    public function shopFilter(){
    	return $this->belongsTo(\App\Models\Product::class, 'product_id')->with(['image', 'color', 'size'])->where('trash', 0);
    }
}
