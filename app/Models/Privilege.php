<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $fillable = ['user_id', 'permission', 'menu', 'sub_menu', 'action_menu'];
}
