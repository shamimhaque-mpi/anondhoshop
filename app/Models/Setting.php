<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
   protected $fillable = ['site_name','title_prefix', 'mobile', 'facebook','youtube','twitter','linkedin','mail','description','fav_icon','logo'];
}
