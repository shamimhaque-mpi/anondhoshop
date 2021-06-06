<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    protected $fillable = ['admin_id','address','facebook','twitter','youtube','linkedin','description'];
}
