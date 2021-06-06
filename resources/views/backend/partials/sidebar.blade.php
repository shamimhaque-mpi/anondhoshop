{{-- fetch all menus with model --}}
@php
	$menu 	= new App\Http\Controllers\Backend\Developer\MenuController();
	$menus 	= $menu->AllMenu();

	$privilege 			= $menu->UserPrivilege() ? $menu->UserPrivilege()->toArray() : [];
	$privilege_menu 	= $privilege ? json_decode($privilege['menu'], true) : [];
	$privilege_subMenu 	= $privilege ? json_decode($privilege['sub_menu'], true) : [];

	$ownSystem = (Auth::guard('admin')->user()->type == "developer");

@endphp

<div class="sidemenu">
	<ul>
		@if(Auth::guard('admin')->user()->type == 'developer')
		@include('backend.partials.dev_menu')
		@endif
		
		<li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : (route('admin.dashboard') != "" ? 'javascript::void(admin.dashboard)' : "") }}"><span class="icon"><i class="fa fa-tachometer"></i></span><span>{{ __('backend/default.dashboard') }}</span></a></li>

		@php($hasMenu = false)
		@foreach($menus as $key=>$menu)
			@if(!$menu->SubMenus->isEmpty() && (in_array($menu->id, $privilege_menu) || $ownSystem))
			@php($hasMenu = true)
		    <li class="dropdown 
		    	@foreach($menu->SubMenus as $key=>$sub_menu) 
		    	{{ Route::has(str_replace('_', '.', $sub_menu->route)) ? (Route::is(str_replace('_', '.',$sub_menu->route)) ? 'active' : '') : '' }} 
		    		@foreach($sub_menu->ActionMenus as $actionMenu)
		    			{{ Route::has(str_replace('_', '.', $actionMenu->route)) ? (Route::is(str_replace('_', '.',$actionMenu->route)) ? 'active' : '') : '' }} 
		    		@endforeach
		    	@endforeach
		    ">
				<a><span class="icon"><i class="{{ $menu->icon }}"></i></span><span>{{ App::isLocale('en') ? $menu->name_en : $menu->name_bn }}</span></a>
				<ul>
					@foreach($menu->SubMenus as $key=>$sub_menu)
						@if(in_array($sub_menu->id, $privilege_subMenu)  || $ownSystem)
						<li class="
							{{ Route::has(str_replace('_', '.', $sub_menu->route)) ? (Route::is(str_replace('_', '.',$sub_menu->route)) ? 'active_child' : '') : '' }}
							@foreach($sub_menu->ActionMenus as $actionMenu)
				    			{{ Route::has(str_replace('_', '.', $actionMenu->route)) ? (Route::is(str_replace('_', '.',$actionMenu->route)) ? 'active_child' : '') : '' }} 
				    		@endforeach
						">
							<a href="{{ Route::has(str_replace('_', '.', $sub_menu->route)) ? route(str_replace('_', '.', $sub_menu->route)) : 'javascript::void('.$sub_menu->route.')' }}"><span class="icon"><i class="{{ $sub_menu->icon }}"></i></span><span>{{ App::isLocale('en') ? $sub_menu->name_en : $sub_menu->name_bn }}</span></a>
						</li>
						 @endif
					@endforeach
				</ul>
		    </li>
			@elseif($menu->route == "" && (in_array($menu->id, $privilege_menu) || $ownSystem)) 
			@php($hasMenu = true)
			    <li><a><span class="icon"><i class="{{ $menu->icon }}"></i></span><span>{{ App::isLocale('en') ? $menu->name_en : $menu->name_bn }}</span></a></li>
			@elseif(in_array($menu->id, $privilege_menu) || $ownSystem)
				@php($hasMenu = true)
			    <li class="{{ Route::is(str_replace('_', '.',$menu->route)) ? 'active' : '' }}"><a href="{{ Route::has(str_replace('_', '.', $menu->route)) ? route(str_replace('_', '.', $menu->route)) : ($menu->route != "" ? 'javascript::void('.$menu->route.')' : "") }}"><span class="icon"><i class="{{ $menu->icon }}"></i></span><span>{{ App::isLocale('en') ? $menu->name_en : $menu->name_bn }}</span></a></li>
			@endif
	    @endforeach
	    @if(!$hasMenu)
    	<li><a><span class="icon">😢</span><span>Please Contact Us For Menu Permission</span></a></li>
	    @endif
	</ul>
</div>
