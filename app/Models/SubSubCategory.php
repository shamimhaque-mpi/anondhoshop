<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'sub_cat_id'];

    // Relation with Sub Category
    public function sub_category(){
    	return $this->hasOne(SubCategory::class, 'id', 'sub_cat_id');
    }
}
