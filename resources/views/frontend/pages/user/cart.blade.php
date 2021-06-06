@extends('frontend.layouts.app')

@section('title', 'Cart')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/cart.css') }}">
@endsection

@section('content')
	<div class="container">
		<cart
			user="{{(Auth::guard('web')->check() ? Auth::guard('web')->user():'')}}"
		></cart>
	</div>
@endsection