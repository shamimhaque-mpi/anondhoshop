<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $fillable = [ 'name_en', 'name_bn', 'url', 'route', 'parent_id', 'icon'];

    // Get Parent Menu
    public function parent() 
    {
    	return $this->hasOne(Menu::class, 'id', 'parent_id'); 

    }

	// Get All Actin Menu
	public function ActionMenus() 
	{
		return $this->hasMany(ActionMenu::class, 'parent_id', 'id');
	}
}
