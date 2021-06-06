<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'purchase_price', 'regular_price', 'unit_id', 'min_sale_quantity', 'slug', 'description', 'discount_persentige', 'discount_flat', 'present_sale_price', 'total_discount_persentige', 'brand_id', 'trash'];

    // Unit 
    public function unit(){
    	return $this->belongsTo(\App\Models\Unit::class)->select('name', 'id');
    }
    // Brand 
    public function brand(){
    	return $this->belongsTo(\App\Models\Brand::class, 'brand_id', 'id')->select('name', 'id');
    }
    // Category 
    public function category(){
    	return $this->belongsToMany(\App\Models\Category::class, 'category_products');
    }
    // Sub Category 
    public function subcategory(){
        return $this->belongsToMany(\App\Models\SubCategory::class, 'product_sub_categories');
    }
    // Sub Category 
    public function subsubcategory(){
        return $this->belongsToMany(\App\Models\SubSubCategory::class, 'product_sub_sub_categories');
    }
    // Sub Category 
    public function color(){
        return $this->belongsToMany(\App\Models\Color::class, 'product_colors');
    }
    // Sub Category 
    public function size(){
        return $this->belongsToMany(\App\Models\Size::class, 'product_sizes');
    }
    // Product Image 
    public function image(){
        return $this->hasMany(\App\Models\Image::class);
    }
    /*
     * +++++++++++++++++++++++++++
     * The following codes 
     * for product editing
     * ++++++++++++++++++++++
    */
    public function category_id(){
        return $this->hasMany(\App\Models\CategoryProduct::class, 'product_id')->select('category_id', 'product_id');
    }
    public function subcategory_id(){
        return $this->hasMany(\App\Models\ProductSubCategory::class, 'product_id')->select('sub_category_id', 'product_id');
    }
    public function subsubcategory_id(){
        return $this->hasMany(\App\Models\ProductSubSubCategory::class, 'product_id')->select('sub_sub_category_id', 'product_id');
    }
    public function color_id(){
        return $this->hasMany(\App\Models\ProductColor::class, 'product_id')->select('color_id', 'product_id');
    }
    public function size_id(){
        return $this->hasMany(\App\Models\ProductSize::class, 'product_id')->select('size_id', 'product_id');
    }
}
