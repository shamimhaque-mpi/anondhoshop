<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    public $fillable = ['title', 'description', 'img_large', 'img_small', 'trash'];
}
