<!DOCTYPE html>
<html>
<head>
	<title>Login Panel</title>
	<meta name="viewport" content="width = device-width, initial-scale=1">
	<link rel="icon" href="{{ asset(siteInfo()->fav_icon) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/css/login.css') }}">
  	<link href="{{ asset('public/backend/plugin/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" >
</head>
<body>
	<section class="login" id="app">
		<div class="gride-1"></div>
		<div class="gride-2"></div>
		<div class="site-name">
			<h2>{{ env('APP_NAME') }}</h2>
		</div>
			<form action="{{ route('admin.login') }}" method="post">
				@csrf
				<div class="login-panel">
					<h2>Login</h2>
					<span class="divition"></span>
					<div class="form">
						<div class="form-group">
							<label>User Name</label>
							<input type="text" name="username" value="{{ old('username') }}" id="username" autocomplete="off" placeholder="Enter Username">
							<span>This Field Can not be enty!</span>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" id="password" placeholder="Enter Password">
							<span>This Field Can not be enty!</span>
							<span id="show"><i class="fa fa-eye" aria-hidden="true"></i></span>
						</div>
						<div class="remember_me">
							<label>
								<input type="checkbox" name="remember_me" >&nbsp;
								<span>Remember Me</span>
							</label>
						</div>
						<div class="submit">
							<a href="#">Forgot Password ?</a>
							<button type="submit"><span><i class="fa fa-sign-in" aria-hidden="true"></i></span></button>
						</div>
					</div>
				</div>
			</form>
	</section>

	{{-- <div class="loader">
		<div class="loader-body">
			<span></span>
		</div>
		<div class="app-name">
			<h3>{{ env('APP_DOMAIN') }}</h3>
		</div>
	</div> --}}
	<script src="{{ asset('public/js/backend/app.js') }}"></script>
</body>
</html>