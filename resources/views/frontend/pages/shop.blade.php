@extends('frontend.layouts.app')

@section('title', 'Shop')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/shop.css') }}">
@endsection

@section('content')

<section class="container shop-wrapper">
	<shop
		:slug="'{{ $slug }}'"
		:ids="{{ $ids }}"
	></shop>
</section>


@endsection