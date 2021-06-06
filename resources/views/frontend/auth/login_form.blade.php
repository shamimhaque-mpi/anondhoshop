@extends('frontend.layouts.app')

@section('title', 'Account')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('public\frontend\css\login_regi.css')}}">
@endsection

@section('content')

<div class="container d-flex justify-content-center">
	<user-login
		site_name="{{ SiteInfo()->site_name }}"
		is_route="{{ Request::route()->uri }}"
		indend_url="{{Session::get('_previous.url', url('/'))}}"
	></user-login>

</div>

@endsection