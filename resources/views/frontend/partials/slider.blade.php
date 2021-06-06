@php
	use App\Repositories\Models;
	$sliders = new Models("Slider");
	$sliders = $sliders->get();
@endphp

<div class="slider">
	<div class="s-slider-wrapper">
		<div class="s-item-container">
			@foreach($sliders as $key=>$slider)
			<div class="s-item">
				<img src="{{ asset($slider->img) }}" alt="{{ $slider->title }}">
			</div>
			@endforeach
		</div>
		<div class="filter"></div>
	</div>
</div>