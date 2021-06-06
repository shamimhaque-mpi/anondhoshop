@extends('backend.layouts.app')

@section('title', 'demo')

@section('content')

<div class="panel min-height-85">
	<div class="panel-title">
		<h2 class="float-left">Admin  Add</h2>
		<a href="{{ route('admin.all') }}" class="btn bg-success float-right">Admin list</a>
	</div>
	<div class="panel-body">
		<form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data" onsubmit="loader('on')">
			@csrf
			<input type="hidden" name="base_token" value="{{ base64_encode(json_encode(['old_email'=>$admin->email, 'old_username'=>$admin->username])) }}">
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
						<input type="text" class="form-control" name="name" value="{{ $admin->name }}" placeholder="Enter Admin Name" required="true">
					</div>
				</div>

				<div class="col-5">
					<div class="form-group">
						<label class="label">Username <strong>*</strong></label>
						<input type="text" class="form-control" name="username" value="{{ $admin->username }}" placeholder="Enter Admin Username" required="true">
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-5">
					<div class="form-group">
						<label class="label">Password <strong>&nbsp;</strong></label>
						<input type="password" class="form-control" name="password" placeholder="Enter New Password If You Wants..">
					</div>
				</div>

				<div class="col-5">
					<div class="form-group">
						<label class="label">Type <strong>*</strong></label>
						<select name="type" class="form-control" required="true">
							<option value="admin" {{ $admin->type == 'admin' ? 'selected' : '' }}>Admin</option>
							<option value="superadmin" {{ $admin->type == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-5">
					<div class="form-group">
						<label class="label">E-mail <strong>*</strong></label>
						<input type="email" name="email" value="{{ $admin->email }}" class="form-control" placeholder="Enter Admin E-mail"> 
					</div>
				</div>

				<div class="col-5">
					<div class="form-group">
						<label class="label">Phone</label>
						<input type="text" name="mobile" value="{{ $admin->mobile }}" class="form-control" placeholder="Enter Admin Phone"> 
					</div>
				</div>
				{{-- <div class="col-5">
					<div class="form-group">
						<label class="label">Address</label>
						<input type="text" name="address" class="form-control" placeholder="Enter Admin Address"> 
					</div>
				</div> --}}
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-10">
					<div class="form-group w10 d-block">
						<input type="submit" value="Submit" class="btn btn-success float-right">
					</div>
				</div>
			</div>

		</form>
	</div>
</div>

@endsection