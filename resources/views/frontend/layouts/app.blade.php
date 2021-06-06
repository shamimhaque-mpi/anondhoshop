<!DOCTYPE html>
<html>
<head>
	<title> {{ SiteInfo()->title_prefix }} | @yield('title') </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="{{ asset(SiteInfo()->fav_icon) }}">

	@include('frontend.partials.style')
	@yield('style')
</head>
<body>
	<div id="app">
		
		<master
			site_url="{{ asset('') }}"
			uri="{{Request::route()->uri}}"
			is_login="{{Auth::guard('web')->check()}}"
			user_pic="{{Auth::guard('web')->check() ? Auth::guard('web')->user()->img : 'false'}}"
		></master>

		@include('frontend.partials.header')

		@yield('content')

		@include('frontend.partials.footer')

	</div>
	@include('frontend.partials.script')
	<script src="{{ asset('public/js/frontend/app.js') }}"></script>
</body>
</html>