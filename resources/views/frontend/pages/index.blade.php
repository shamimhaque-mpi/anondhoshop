@extends('frontend.layouts.app')

@section('title', 'Home')

@section('style')

<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/home.css') }}">
<link rel="stylesheet" href="{{ asset('public/frontend/css/slider.css') }}" />

@endsection

@section('content')

@include('frontend.partials.slider')

<!-- Our Service -->
<div style="background: #fff;">
	<div class="container">
		<div class="our-service">
			<div class="w10"><h2 class="head-title">Our Service</h2></div>
			@foreach($services as $service)
			<div class="service">
				<a href="#">
					<div class="service-card">
						<div class="img">
							<img src="{{ asset($service->img_small) }}">
						</div>
						<div class="info">
							<h3 class="card-title">{{(strlen($service->title) > 28 ? substr($service->title, 0, 26).'...' : $service->title)}}</h3>
							<p class="details">{{$service->description}}</p>
						</div>
					</div>
				</a>
			</div>
			@endforeach
			<div class="col-9">
				<a href="#" class="cat-show-all"><span>View More</span></a>
			</div>
		</div>
	</div>
</div>
<category></category>
<!-- 
	End Popular Category Section
-->
<section class="container products-box">
	<product-home></product-home>
</section>


@endsection