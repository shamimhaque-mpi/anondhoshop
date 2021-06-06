@extends('backend.layouts.app')

@section('title', 'Product/List')

@section('content')

<div class="panel min-height-90">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-plus"></i>&nbsp; All Product</h2>
		<a href="{{ route('admin.product.add') }}" class="btn-sml bg-success">Add</a>
	</div>
	<div class="panel-body">
		<add-list></add-list>
	</div>
</div>

@endsection
