<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'cat_id'];

    // Relation with Category
    public function category(){
    	return $this->hasOne(Category::class, 'id', 'cat_id')->select('id', 'name');
    }

    // Relation with Sub Category
    public function sub_sub_category(){
    	return $this->hasMany(SubSubCategory::class, 'sub_cat_id', 'id')->select('id', 'sub_cat_id', 'name');
    }
}


