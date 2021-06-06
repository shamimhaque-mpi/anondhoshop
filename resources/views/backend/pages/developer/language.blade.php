@extends('backend.layouts.app')

@section('title', 'demo')

@section('content')
<div class="panel min-height-85">
	<div class="panel-title">
		<h2 class="float-left p-2 pl-0"><span><i class="fa fa-language"></i></span>&nbsp;Add Localization</h2>
		{{-- <a href="route('admin.all')" class="btn bg-success float-right">Add Localization</a> --}}
	</div>
	<div class="panel-body">
		<form action="{{ route('developer.language.store')  }}" method="POST" enctype="multipart/form-data" onsubmit="loader('on')">
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
				<div class="col-3">
					<div class="form-group">
						<label class="label">Tag <strong>*</strong></label>
						<input type="text" class="form-control" name="tag" placeholder="Enter Tag Name" required="true" autocomplete="off">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="label"> Name(English) <strong>*</strong></label>
						<input type="text" class="form-control" name="name_en"  placeholder="Enter Name In English" required="true" autocomplete="off">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="label"> Name(Bangla) <strong>*</strong></label>
						<input type="text" class="form-control" name="name_bn" placeholder="Enter Name in Bangla" required="true" autocomplete="off">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="label">Type <strong>*</strong>  &nbsp; <i class="fa fa-spinner fa-pulse text-danger float-right mr-3 strong d-none"></i></label>
						<select name="type" class="form-control" id="type" required="true">
							<option value="backend">Backend</option>
							<option value="frontend">Frontend</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="label">File <strong>*</strong> &nbsp; <i class="fa fa-spinner fa-pulse text-danger float-right mr-3 strong d-none"></i></label>
						<select name="file" class="form-control" id="file" required="true">
							{{-- <option value="default">default</option> --}}
							@foreach($files as $file)
								<option value="{{ $file }}">{{ ucfirst($file) }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-3">
					<div class="form-group">
						<label class="label"> New file </label>
						<input type="text" class="form-control" name="new_file" placeholder="Enter New File Name" autocomplete="off">
					</div>
				</div>

				<div class="col-6">
					<div class="form-group w10 d-block">
						<input type="submit" value="Save" class="btn btn-success float-right">
					</div>
				</div>

			</div>
		</form>
	</div>
</div>

@endsection

@section('script')
	<script>
		window.addEventListener('load', ()=>{
			let type = document.querySelector('#type');
			let file = document.querySelector('#file');

			let loader1 = type.parentElement.querySelector('i');
			let loader2 = file.parentElement.querySelector('i');

			type.addEventListener('change', ()=>{
				file.innerHTML = '';
				loader1.classList.remove('d-none');
				loader2.classList.remove('d-none');
				fetch('{{ route('developer.lang.files') }}/'+type.value)
				.then(json=>json.json())
				.then(data=>{
					if(data.length > 0){
						file.innerHTML = `<option disabled="true" selected="true" class="text-center">Select a file name</option>`;
					}else{
						file.innerHTML = `<option disabled="true" selected="true" class="text-center">Please Atfirst Select Type</option>`;
					}

					data.forEach((value)=>{
						let select = document.createElement('option');
						select.setAttribute('value', value);
						select.innerHTML = value[0].toUpperCase()+value.substring(1);
						file.append(select);
					});
					loader1.classList.add('d-none');
					loader2.classList.add('d-none');
				});
			});
		});
	</script>
@endsection