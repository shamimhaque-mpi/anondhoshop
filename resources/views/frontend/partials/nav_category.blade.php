@php
	$category_mdl 	= new \App\Repositories\Models('Category');
	$categories 	= $category_mdl->take(10)->get();
	$total_category = $category_mdl->count();
@endphp
<div class="categories">
	<a href="#" title="">Categories</a>
	<ul class="category-menu">
		@if($categories)
			@foreach($categories as $key=>$category)
			<!-- Fetch Category -->
				@if($category->sub_category->isEmpty())
				<!-- Category -->
					@php
						$slug = "{ \"category\": $category->id }";
						$slug = base64_encode((string)$slug);
					@endphp
					<li><a href="{{ route('shop', $slug) }}">{{ $category->name }}</a></li>
				@else
				<!-- Category -->
					<li class="dropdown">

						<a href="">{{ $category->name }}</a>
						<ul class="sub-category-menu">
							@foreach($category->sub_category as $key2=>$sub_category)
							<!-- Sub Category -->
								@if($sub_category->sub_sub_category->isEmpty())
									<li><a href="#">{{ $sub_category->name }}</a></li>
								@else
								<!-- Sub Category -->
									<li class="dropdown">
										<a href="#">{{ $sub_category->name }}</a>
										<ul class="sub-sub-category-menu">
											<!-- Sub Sub Category -->
											@foreach($sub_category->sub_sub_category as $key3=>$sub_sub_category)
											<li><a href="#">{{ $sub_sub_category->name }}</a></li>
											@endforeach
										</ul>
									</li>
								@endif
							@endforeach
						</ul>
					</li>
				@endif
			@endforeach
			@if($total_category > 10)
			<li><a href="#" class="link">See More ({{$total_category-10}})</a></li>
			@endif
		@endif
	</ul>
</div>