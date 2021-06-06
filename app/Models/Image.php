<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['large', 'medium', 'small', 'smaller', 'product_id', 'color_id', 'size_id'];
}
