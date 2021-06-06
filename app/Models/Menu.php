<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $fillable = ['name_en','name_bn' , 'url', 'route', 'icon'];

	// Get Sub Menu
    public function SubMenus()
    {
    	return $this->hasMany(SubMenu::class, 'parent_id', 'id');
    }
}
