@extends('backend.layouts.app')

@section('title', 'Orders')

@section('style')
	<style>
		.table caption{
			text-align: left;
			padding-bottom: 5px;
			padding-left: 3px;
		}
	</style>
@endsection

@section('content')
<div class="panel min-height-90  position-relative">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-cart-arrow-down"></i>&nbsp; Orders</h2>
	</div>
	<div class="panel-body">
		<orders></orders>
	</div>
		
</div>

@endsection
