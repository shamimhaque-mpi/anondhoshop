@extends('backend.layouts.app')

@section('title', 'Add Service')

@section('style')

@endsection

@section('content')
<div class="panel min-height-90  position-relative">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-plus"></i>&nbsp; Add Service</h2>
	</div>
	<div class="panel-body">
		<div class="row d-flex justify-content-center">
			<div class="col-10">
				<form action="{{route('admin.services.add')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<label class="label text-right col-2">Title <strong class="required">*</strong></label>
						<div class="col-9">
							<input type="text" name="title" class="form-control" placeholder="Enter Title.." required>
						</div>

						<label class="label text-right col-2">Description <strong class="required">*</strong></label>
						<div class="col-9">
							<textarea rows="18" name="description" class="form-control" placeholder="Enter Descriptions..." required></textarea>
						</div>

						<label class="label text-right col-2">Image <strong class="required">*</strong></label>
						<div class="col-9">
							<input type="file" name="img" class="form-control" required>
						</div>
						<div class="col-11">
							<div class="btn-group float-right">
								<input type="submit" class="btn btn-success">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection