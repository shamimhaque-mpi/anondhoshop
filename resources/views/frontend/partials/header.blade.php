<header class="header-wrapper">
	<!-- top information bar -->
	<div class="important-link">
		<div class="container  d-flex space-between align-items-center">
			<div class="contact">
				<a href="tel:{{ SiteInfo()->mobile }}">
					<span class="social-icon-svg">
						<img src="{{asset('public/frontend/icon/mobile.svg')}}">					
					</span>
					<span><span class="contact-title">&nbsp;Contact Us </span>{{ SiteInfo()->mobile }}</span>
				</a title="">
			</div>	
			<div>
				<ul>
					@if(!Auth::guard('web')->check())
					<li>
						<a href="{{ route('signup') }}">SIGN UP</a>
					</li>
					<li>
						<a href="{{ route('login') }}">LOGIN</a>
					</li>
					@else
					<li>
						<a href="">TRACK MY ORDER</a>
					</li>
					@endif
				</ul>
			</div>			
		</div>
	</div>
	<!-- nav var -->
	<div class="header-sticky">
		<div class="header">
			<div class="container">
				<!--  Site Logo  -->
				<div class="group">
					<div class="site-logo align-self-center">
						<a href="{{ url('/') }}" style="display: block;">
							<div class="logo">
								<img src="{{ asset(SiteInfo()->logo) }}">
							</div>
						</a>
					</div>
					<!--  
						Search Bar  
					-->
					<search></search>

					<div class="user-profile align-self-center">

						<a href="#" id="search_btn">
							<span class="svg-icon">
								<img src="{{asset('public/frontend/icon/search.svg')}}">
							</span>
						</a title="">
						@if(Auth::guard('web')->check())
						<a href="#" class="user_profile">
							<div class="img">
								<img src="{{ asset('public/frontend/icon/user.svg') }}" alt="">
							</div>
						</a title="">
						@endif
						<a class="ml-2">
							<div class="front-site-btn">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</a title="">
					</div>
					<!--  
						User Action  
					-->
					<user-notification></user-notification>
					
					<div class="notification" id="notification">
						<ul>
							<li><a href="#">Your Profile is't complete Your Profile is't complete</a></li>
						</ul>
					</div>
					<!-- 
						User Log 
					-->
					@if(Auth::guard('web')->check())
					<div class="user-logbar" id="user_log">
						<ul>
							<li><a href="{{route('home')}}"><h3>{{Auth::guard('web')->user()->name}}</h3></a></li>
							<li><a href="{{route('home')}}">Dashboard</a></li>
							<li><a href="{{route('logout')}}">Logout</a></li>
						</ul>
					</div>
					@endif
				</div>
				<!--  End  -->
			</div>
			<div class="menu-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-2 p-0">
							@include('frontend.partials.nav_category')
						</div>

						<div class="col-8 p-0">
							<div class="menu">
								@if(Auth::guard('web')->check())
								<user-menu
									name="{{Auth::guard('web')->user()->name}}"
									type="nav"
								></user-menu>
								@endif
								<ul>
									<li class="{{ Route::is('shop') ? 'active' : '' }}"><a href="{{ route('shop') }}"  title="">Shop</a></li>
									<li class="{{Route::is('our_servce')?'active':''}}"><a href="{{route('our_servce')}}" title="">Our Services</a></li>
									<li class="{{Route::is('about_us')?'active':''}}"><a href="{{route('about_us')}}" title="">About us</a></li>
									<li class="{{Route::is('contact_us')?'active':''}}"><a href="{{route('contact_us')}}" title="">Contact us</a></li>
								</ul>
							</div>
						</div>
						<div class="col-2 login-signup">
							@if(Auth::guard('web')->check())
							<a href="{{ route('logout') }}">Logout</a>
							@else
							<a href="{{ route('login') }}">Login / SignUp</a>
							@endif
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</header>