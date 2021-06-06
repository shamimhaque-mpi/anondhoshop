@extends('backend.layouts.app')

@section('title', 'All Services')

@section('style')

@endsection

@section('content')
<div class="panel min-height-90  position-relative">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-list-ul"></i>&nbsp; All Services</h2>
	</div>
	<div class="panel-body">
		@if(!$allServices->isEmpty())
		<div class="table-responsive">
			<table class="table table-border data-table">
				<tr>
					<th>SL</th>
					<th>Date</th>
					<th>Image</th>
					<th>Title</th>
					<th>Descrption</th>
					<th>Action</th>
				</tr>
				@foreach($allServices as $key=>$service)
				<tr>
					<td>{{++$key}}</td>
					<td>{{$service->created_at}}</td>
					<td><img src="{{ asset($service->img_small) }}" height="40"></td>
					<td>{{$service->title}}</td>
					<td>{{substr($service->description, 0, 50).(strlen($service->title)>50?' ...':'')}}</td>
					<td>
						<div class="btn-group">
							@foreach(action_menu() as $btn)
								@if($btn->name=='view')
								<a href="{{route($btn->route, $service->id)}}" class="btn-sml btn-view"></a>
								@elseif($btn->name=='edit')
								<a href="{{route($btn->route, $service->id)}}" class="btn-sml btn-edit"></a>
								@elseif($btn->name=='delete')
								<a href="{{route($btn->route, $service->id)}}" class="btn-sml btn-trash delete-alert"></a>
								@endif
							@endforeach
						</div>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		@else
		<h3>No Data Available </h3>
		@endif

	</div> 
</div>

@endsection