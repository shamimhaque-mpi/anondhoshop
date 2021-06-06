@extends('backend.layouts.app')

@section('title', 'demo')

@section('content')

<div class="panel min-height-85">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center"><i class="fa fa-plus"></i>&nbsp;Admin  Add</h2>
		<a href="{{ route('admin.all') }}" class="btn-sml bg-success">Admin list</a>
	</div>
	<div class="panel-body">
		<form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" onsubmit="loader('on')">
			@csrf
			<div class="row">
				@if($errors->any())
				<div class="col-12">
					<div class="bg-warning text-white p-3">
						@foreach($errors->all() as $key=>$error)
							<strong>{{ $error }}</strong><br>
						@endforeach
					</div>
				</div>
				@endif
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-5">
					<div class="form-group">
						<label class="label">Name <strong>*</strong></label>
						<input type="text" class="form-control" name="name" placeholder="Enter Admin Name" required="true">
					</div>
				</div>

				<div class="col-5">
					<div class="form-group">
						<label class="label">Username <strong>*</strong></label>
						<input type="text" class="form-control" name="username" placeholder="Enter Admin Username" required="true">
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-5">
					<div class="form-group">
						<label class="label">Password <strong>*</strong></label>
						<input type="password" class="form-control" name="password" placeholder="Enter Admin Password" required="true">
					</div>
				</div>

				<div class="col-5">
					<div class="form-group">
						<label class="label">Type <strong>*</strong></label>
						<select name="type" class="form-control" required="true">
							<option value="admin" >Admin</option>
							<option value="superadmin" >Super Admin</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-5">
					<div class="form-group">
						<label class="label">E-mail <strong>*</strong></label>
						<input type="email" name="email" class="form-control" placeholder="Enter Admin E-mail"> 
					</div>
				</div>

				<div class="col-5">
					<div class="form-group">
						<label class="label">Phone</label>
						<input type="text" name="mobile" class="form-control" placeholder="Enter Admin Phone"> 
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-10">
					<div class="form-group w10 d-block">
						<input type="submit" value="Submit" class="btn btn-success float-right radius-0">
					</div>
				</div>

			</div>
		</form>
	</div>
</div>

@endsection