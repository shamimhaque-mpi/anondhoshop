

<li class="dropdown dev {{ Request::is('developer/*') ? 'active' : '' }}">
	<a><span class="icon"><i class="fa fa-hashtag"></i></span><span>Developer</span></a>
	<ul>
		<li class="{{ Route::has('developer') ? ( Route::is('developer') || Route::is('developer.menu.edit') ? 'active_child' : '' ) : ''}}"><a href="{{ Route::has('developer') ? route('developer') : 'javascript::void("developer")' }}"><span class="icon"><i class="fa fa-list-ul"></i></span><span>All Menu</span></a></li>
		<li class="{{ Route::has('developer.menu.add') ? ( Route::is('developer.menu.add') ? 'active_child' : '' ) : ''}}"><a href="{{ Route::has('developer.menu.add') ? route('developer.menu.add') : 'javascript::void("developer.menu.add")' }}"><span class="icon"><i class="fa fa-plus"></i></span><span>Add Menu</span></a></li>
		<li class="{{ Route::has('developer.language') ? ( Route::is('developer.language') ? 'active_child' : '' ) : ''}}"><a href="{{ Route::has('developer.language') ? route('developer.language') : 'javascript::void("developer.language")' }}"><span class="icon"><i class="fa fa-language"></i></span><span>Localization</span></a></li>
	</ul>
</li>