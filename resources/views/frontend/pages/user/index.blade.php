@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@section('style')
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/user_panel.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/cart.css')}}">
@endsection

@section('content')

<section class="container">
	<user-panel
		name="{{Auth::guard('web')->user()->name}}"
	>
	</user-panel>
</section>


@endsection