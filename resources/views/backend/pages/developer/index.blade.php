@extends('backend.layouts.app')

@section('title', 'Demo-Developer')

@section('style')
<style>
	.tab {
	    background: #b1b1b138;
	    margin-bottom: 7px;
	}
	.tab > ul {
		display: flex;
	}
	.tab > ul >li {
	    list-style: none;
	    padding: 10px;
	    border-right: 2px solid #ddd;
	    text-align: center;
	    width: 106px;
	    cursor: pointer;
	    user-select: none;
		transition: all .5s;
	}
	.tab > ul >li:hover {
	    background: #d8d8d8;
	    color: #48483c;
	}
	.tab > ul >li.active {
	    background: #526484;
	    color: #97ffe2;
	}
</style>
@endsection

@section('content')
	<div class="panel min-height-85">
		<div class="panel-title d-flex space-between">
		 	<h2 class="align-self-center title"><i class="fa fa-list"></i>&nbsp;All Menus</h2>
		  	<a href="{{ route('developer.menu.add') }}" class="btn-sml bg-success radius"><span><i class="fa fa-plus"></i></span>&nbsp;Add Menu</a>
		</div>
		<div class="panel-body">
			<div class="tab" id="tab">
				<ul>
				    <li class="active" data-menu="menu">Menu</li>
				    <li data-menu="sub_menu">Sub Menu</li>
				    <li data-menu="action_menu">Action Menu</li>
				</ul>
			</div>

			<!-- start menu table -->
		  	<div class="table-responsive menu_table" data-menu="menu">
			    <table class="table data-table">
			      	<tr>
			        	<th width="5%">SL</th>
			        	<th>Name(English)</th>
			        	<th>Name(Bangla)</th>
			        	<th>Route</th>
			        	<th>URL</th>
			        	<th>SubMenu</th>
			        	<th class="text-center">Icon</th>
			        	<th width="10%" class="text-center">Action</th>
			      	</tr>
		      		@foreach($menus as $key=>$menu)
			      	<tr>
			        	<td>{{ $key+1 }}</td>
			        	<td>{{ $menu->name_en }}</td>
			        	<td>{{ $menu->name_bn }}</td>
			        	<td>{{ $menu->route != '' ? $menu->route : 'N/A'  }}</td>
			        	<td>{{ $menu->url != '' ? $menu->url : 'N/A'  }}</td>
							{{-- Sub-Menus --}}
			        	<td>
			        		@php
			        			$count = $menu->SubMenus->count();
			        		@endphp
			        		@if($count > 0)
			        			<span class="text-success strong">({{ $count }})</span>	<br>
			        			<span class="d-flex-w">
			        				@foreach($menu->SubMenus as $key2=>$submenu)
				        				@if($key2+1 == $count)
				        				{{ $submenu->name_en }}
				        				@else
				        				{{ $submenu->name_en }} |
				        				@endif
				        			@endforeach	 
			        			</span>
			        		@else	        	
			        			<span class="text-danger strong">({{ $count }})</span>		        	
			        		@endif 		
			        	</td>
			        	<td class="text-center"><span><i class="{{ $menu->icon }}"></i></span></td>
				        <td>
				          	<div class="btn-group btn-margin justify-content-center w10">
				           		<a href="{{ route('developer.menu.delete', ['menu', $menu->id]) }}" class="btn-sml btn-trash delete-alert" data-protected="on"></a>
				           		<a href="{{ route('developer.menu.edit', ['menu', $menu->id]) }}" class="btn-sml btn-edit"></a>
				          	</div>
				        </td>
			    	</tr>
		      		@endforeach
		    	</table>
		  	</div>
		  	<!-- end menu table -->

			<!-- start sub menu table -->
		  	<div class="table-responsive d-none menu_table" data-menu="sub_menu">
			    <table class="table data-table">
			      	<tr>
			        	<th width="5%">SL</th>
			        	<th>Name(English)</th>
			        	<th>Name(Bangla)</th>
			        	<th>Parent</th>
			        	<th>Route</th>
			        	<th>URL</th>
			        	<th>Action-Menu</th>
			        	<th class="text-center">Icon</th>
			        	<th width="10%" class="text-center">Action</th>
			      	</tr>
		      		@foreach($subMenus as $key=>$subMenu)
			      	<tr>
			        	<td>{{ $key+1 }}</td>
			        	<td>{{ $subMenu->name_en }}</td>
			        	<td>{{ $subMenu->name_bn }}</td>
			        	<td>{{ $subMenu->parent->name_en }}</td>
			        	<td>{{ $subMenu->route }}</td>
			        	<td>{{ $subMenu->url }}</td>
			        	<td>
			        		
			        		@php
			        			$count = $subMenu->ActionMenus->count();
			        		@endphp
			        		@if($count > 0)
			        			<span class="text-success strong">({{ $count }})</span><br>	
			        			<span class="d-flex-w">
				        			@foreach($subMenu->ActionMenus as $key2=>$ActionMenu)
				        				@if($key2+1 == $count)
				        				{{ $ActionMenu->name_en }}
				        				@else
				        				{{ $ActionMenu->name_en }} |
				        				@endif
				        			@endforeach   
			        			</span> 
			        		@else	        	
			        			<span class="text-danger strong">({{ $count }})</span>		        	
			        		@endif
			        		    		
			        	</td>
			        	<td class="text-center"><span><i class="{{ $subMenu->icon }}"></i></span></td>
				        <td>
				          	<div class="btn-group btn-margin justify-content-center w10">
				           		<a href="{{ route('developer.menu.delete', ['sub_menu', $subMenu->id]) }}" class="btn-sml btn-trash delete-alert"></a>
				           		<a href="{{ route('developer.menu.edit', ['sub_menu', $subMenu->id]) }}" class="btn-sml btn-edit"></a>
				          	</div>
				        </td>
			    	</tr>
		      		@endforeach
		    	</table>
		  	</div>
		  	<!-- end sub menu table -->

			<!-- start action menu table -->
		  	<div class="table-responsive d-none menu_table" data-menu="action_menu">
			    <table class="table data-table">
			      	<tr>
			        	<th width="5%">SL</th>
			        	<th>Name(English)</th>
			        	<th>Name(Bangla)</th>
			        	<th>Parent</th>
			        	<th>Route</th>
			        	<th>URL</th>
			        	<th class="text-center">Icon</th>
			        	<th width="10%" class="text-center">Action</th>
			      	</tr>
		      		@foreach($actionMenus as $key=>$actionMenu)
			      	<tr>
			        	<td>{{ $key+1 }}</td>
			        	<td>{{ $actionMenu->name_en }}</td>
			        	<td>{{ $actionMenu->name_bn }}</td>
			        	<td>{{ $actionMenu->parent->name_en }}</td>
			        	<td>{{ $actionMenu->route }}</td>
			        	<td>{{ $actionMenu->url }}</td>
			        	<td class="text-center"><span><i class="{{ $actionMenu->icon }}"></i></span></td>
				        <td>
				          	<div class="btn-group btn-margin justify-content-center w10">
				           		<a href="{{ route('developer.menu.delete', ['action_menu', $actionMenu->id]) }}" class="btn-sml btn-trash"></a>
				           		<a href="{{ route('developer.menu.edit', ['action_menu', $actionMenu->id]) }}" class="btn-sml btn-edit"></a>
				          	</div>
				        </td>
			    	</tr>
		      		@endforeach
		    	</table>
		  	</div>
		  	<!-- end action menu table -->

		</div>
	</div>
@endsection

@section('script')
<script>
	(()=>{
		window.addEventListener('load', ()=>{
			// getting tags for conbination
			let tab_menus   = document.querySelectorAll('.tab > ul > li');
			let menu_tables = document.querySelectorAll('.menu_table');
			// fetcing sigle tag and checking click event
			if(tab_menus.length > 0 && menu_tables.length > 0){
				tab_menus   = Array.isArray(tab_menus)   ? tab_menus   : Object.values(tab_menus);
				menu_tables = Array.isArray(menu_tables) ? menu_tables : Object.values(menu_tables);
				// Fetch all btn
				tab_menus.forEach((value, key)=>{
					// Add Event on sigle btn
					value.addEventListener('click', ()=>{
						// Fetch all btn
						tab_menus.forEach((value2, key2)=>{
							if(key == key2){
								value2.classList.add('active');
								let tab_menu = value.dataset.menu;
								// Fetch all Table
								menu_tables.forEach((table_value)=>{
									// Checking table key and btn-sml key
									if(table_value.dataset.menu == tab_menu) {
										if(table_value.classList.contains('d-none')) {
											table_value.classList.remove('d-none');
										}
									}
									else {
										table_value.classList.add('d-none');
									}
								});
							}
							else{
								if(value2.classList.contains('active')){
									value2.classList.remove('active');
								}
							}
						});
					});
				});
			} 
		});
	})()
</script>
@endsection