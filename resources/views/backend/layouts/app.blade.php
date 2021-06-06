<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> {{ SiteInfo()->title_prefix }} | @yield('title')</title>
	<meta name="viewport" content="width = device-width, initial-scale=1">
	<link rel="icon" href="{{ asset(SiteInfo()->fav_icon) }}">

	{{-- all style --}}
	@include('backend.partials.style')

	{{-- all script --}}
	@include('backend.partials.script')

	{{-- page style --}}
	@yield('style')

</head>

<body>
	<div id="app">
		<default
			site_url 	= "{{ url('') }}"
			admin_photo = "{{ Auth::guard('admin')->user()->photo }}"
			admin_name 	= "{{ Auth::guard('admin')->user()->name }}"
			admin_type 	= "{{ Auth::guard('admin')->user()->type }}"
		>
		</default>
		<div class="body_wrapper">
			<!--   ======================== nav ======================== -->
			@include('backend.partials.nav')
			  
			<!--   ==================== Sidebar Menu =================== -->
			@include('backend.partials.sidebar')

			<!--   ================== body of the page ================= -->
			<div class="page_body">
				@yield('content')
			</div>
		</div>
		{{-- loader --}}
		@include('backend.partials.loader')
	</div>

	{{-- page script --}}
	@yield('script')

	{{-- Fash message --}}
	@include('backend.partials.message')
	
	<script src="{{ asset('public/js/backend/app.js') }}"></script>
</body>
</html>