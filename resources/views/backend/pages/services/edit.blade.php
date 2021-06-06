@extends('backend.layouts.app')

@section('title', 'Edit Service')

@section('style')

@endsection

@section('content')
<div class="panel min-height-90  position-relative">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-plus"></i>&nbsp; Edit Service</h2>
	</div>
	<div class="panel-body">
		<div class="row d-flex justify-content-center">
			<div class="col-10">
				<form action="{{route('admin.services.edit', $service->id)}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card p-3">
						<div class="form-group">
							<label class="label">Title <strong class="required">*</strong></label>
							<input type="text" name="title" value="{{$service->title}}" class="form-control" required>
						</div>
						<div class="form-group">
							<label class="label">Description <strong class="required">*</strong></label>
							<textarea rows="18" name="description" class="form-control" required>{{$service->description}}</textarea>
						</div>
						<div class="form-group col-5 float-left">
							<label class="label">Image </label>
							<input type="file" name="img" class="form-control">
						</div>
						<div class="btn-group float-right mt-5">
							<input type="submit" class="btn btn-success">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection