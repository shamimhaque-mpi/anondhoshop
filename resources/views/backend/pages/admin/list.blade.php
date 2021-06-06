@extends('backend.layouts.app')

@section('title', 'Admin-List')

@section('style')

@endsection

@section('content')
	<div class="panel min-height-85">
		<div class="panel-title d-flex space-between">
		 	<h2 class="align-self-center title"><span><i class="fa fa-users"></i></span> &nbsp;Admin List</h2>
		  	<a href="{{ route('admin.add') }}" class="btn-sml bg-success"><span><i class="fa fa-plus"></i></span>&nbsp;Add Admin</a>
		</div>
		<div class="panel-body">

			<!-- start sub menu table -->
		  	<div class="table-responsive menu_table" data-menu="sub_menu">
			    <table class="table data-table">
			      	<tr>
			        	<th width="5%">SL</th>
			        	<th>Name</th>
			        	<th>Username</th>
			        	<th>Type</th>
			        	<th>Phone</th>
			        	<th width="10%">Action</th>
			      	</tr>
		      		@foreach($admins as $key=>$admin)
			      	<tr>
			        	<td>{{ $key+1 }}</td>
			        	<td>{{ $admin->name }}</td>
			        	<td>{{ $admin->username }}</td>
			        	<td>{{ $admin->type }}</td>
			        	<td>{{ $admin->mobile }}</td>
				        <td>
				          	<div class="btn-group justify-content-center w10">
								@php($menu = new App\Http\Controllers\Backend\Developer\MenuController())
								@foreach($menu->SubMenus() as $sub_menu)
					           		<a href="{{ route($sub_menu->route, $admin->id) }}" class="btn-sml radius-0 {{ ($sub_menu->name == 'delete' ? 'btn-trash delete-alert' : ($sub_menu->name == 'edit' ? 'btn-edit' : ($sub_menu->name == 'view' ? 'btn-view' : ($sub_menu->name == 'deactive' ? 'btn-block' : '')))) }}" title=">{{ $sub_menu->name_locale }}"></a>
								@endforeach
				          	</div>

				        </td>
			    	</tr>
		      		@endforeach
		    	</table>
		  	</div>
		  	<!-- end sub menu table -->

		</div>
	</div>
@endsection

@section('script')

@endsection