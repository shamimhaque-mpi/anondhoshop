<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image'];

    // Relation with Sub Category
    public function sub_category()
    {
    	return $this->hasMany(SubCategory::class, 'cat_id', 'id')->select('id', 'name', 'cat_id')->with(['sub_sub_category']);
    }
}
