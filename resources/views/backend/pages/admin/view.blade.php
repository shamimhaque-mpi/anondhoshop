@extends('backend.layouts.app')

@section('title', 'Admin-List')

@section('style')
	<style type="text/css" rel="stylesheet">
		.profile-photo {
			width: 200px;
			height: 200px;
		}
	</style>
@endsection

@section('content')
	<div class="panel min-height-85">
		<div class="panel-title">
		 	<h2 class="float-left"><span><i class="fa fa-users"></i></span> &nbsp;Admin List</h2>
		  	<a href="{{ route('admin.all') }}" class="btn bg-success float-right"><span><i class="fa fa-list"></i></span>&nbsp;Admin List</a>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-2">
					<div class="profile-photo p-1 mb-2 border">
						<img src="{{ asset($admin->photo ?? 'public/backend/icon/man.webp') }}" class="responsive" alt="">
					</div>					
				</div>
				<div class="col-10">
				  	<div class="card">
					  	<div class="table-responsive">
						    <table class="table">
						    	<caption class="text-left pb-2 pt-2 strong"><span>Basic Information :</span></caption>
						      	<tr>
						        	<th>Name</th>
						        	<th>Username</th>
						        	<th>E-mail</th>
						        	<th>Phone</th>
						        	<th>Type</th>
						      	</tr>
						      	<tr>
						        	<td>{{ $admin->name }}</td>
						        	<td>{{ $admin->username }}</td>
						        	<td>{{ $admin->email }}</td>
						        	<td>{{ $admin->mobile }}</td>
						        	<td>{{ $admin->type }}</td>
						    	</tr>
					    	</table>
					  	</div>
					  	<div class="table-responsive">
						    <table class="table border-0">
						    	<caption class="text-left pb-2 pt-2 strong"><span>OVER VIEW :</span></caption>
						      	<tr>
						        	<th class="text-right" width="150">Address:</th>
						        	<td>{{ $admin->adminInfo->address ?? '' }}</td>
						      	</tr>
						      	<tr>
						        	<th class="text-right" width="150">Facebook:</th>
						        	<td>{{ $admin->adminInfo->facebook ?? '' }}</td>
						      	</tr>
						      	<tr>
						        	<th class="text-right" width="150">Twitter:</th>
						        	<td>{{ $admin->adminInfo->twitter ?? '' }}</td>
						      	</tr>
						      	<tr>
						        	<th class="text-right" width="150">Linkedin:</th>
						        	<td>{{ $admin->adminInfo->linkedin ?? '' }}</td>
						      	</tr>
						      	<tr>
						        	<th class="text-right" width="150">Youtube:</th>
						        	<td>{{ $admin->adminInfo->youtube ?? '' }}</td>
						      	</tr>
						      	<tr>
						        	<th class="text-right" width="150">Description:</th>
						        	<td>{{ $admin->adminInfo->description ?? '' }}</td>
						      	</tr>
					    	</table>
					  	</div>
				  	</div>

				</div>
			</div>


		</div>
	</div>
@endsection

@section('script')

@endsection