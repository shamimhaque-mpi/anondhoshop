<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionMenu extends Model
{
    protected $fillable = ['name_en', 'name_bn', 'parent_id', 'icon', 'url', 'route'];

	// Get parent Menu
    public function parent() {
    	return $this->hasOne(SubMenu::class, 'id', 'parent_id');
    }
}

