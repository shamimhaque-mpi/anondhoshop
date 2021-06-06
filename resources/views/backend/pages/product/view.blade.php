@extends('backend.layouts.app')

@section('title', 'Product/View')

@section('style')
<style>
	.image-wrapper{
		width: 450px;
		height: 400px;
		display: grid;
	}
	.image {
	    border: 1px solid #ddd;
	    width: 310px;
	    height: 310px;
	    justify-self: center;
	}
	.avata-wrapper {
	    width: 450px;
	    overflow-y: hidden;
	    overflow-x: auto;
	}
	.avata {
	    height: 86px;
	    flex-wrap: nowrap;
	    min-width: inherit;
	    display: flex;
	}
	.tamnil {
	    width: 60px;
	    height: 60px;
	    padding: 1px;
	    border: 2px solid #f1eded;
	    margin-right: 4px;
	    align-self: center;
	    cursor: pointer;
	}
</style>
@endsection

@section('content')

<div class="panel min-height-90">
	<div class="panel-title d-flex space-between">
		<h3 class="title"><i class="fa fa-plus"></i>&nbsp;Product Review</h3>
		<a href="{{ route('admin.product.list') }}" class="btn btn-success btn-sml radius">List</a>
	</div>
	<div class="panel-body">
		<div class="table-resposive">
			<table class="table">
				<caption class="text-left strong pl-1 pb-1">Basic Information</caption>
				<tr>
					<th width="150">Product Name</th>
					<td colspan="7">{{ $result->name }}</td>
				</tr>
				<tr>
					<th>Entry Date</th>
					<td>{{ substr($result->created_at, 0, 10) }}</td>

					<th>Brand</th>
					<td colspan="5">{{ ($result->brand ? $result->brand->name : 'N/A') }}</td>
 				</tr>
 				<tr>
					<th width="150">Purchase Price</th>
					<td>{{ $result->purchase_price }} tk</td>

					<th width="150">Regular Price</th>
					<td>{{ $result->regular_price }} tk</td>

					<th width="150">Sale Price</th>
					<td>{{ $result->present_sale_price }} tk</td>

					<th width="150">Min-Sale Qty</th>
					<td>{{ $result->min_sale_quantity }} {{ $result->unit ? $result->unit->name : ''}}</td>
				</tr>
 				<tr>
					<th width="150">Flat Discount</th>
					<td>{{ $result->discount_flat }} tk</td>

					<th width="150">Persentige Discount</th>
					<td>{{ $result->discount_persentige }} %</td>
					@php
						$remission = $result->regular_price - $result->present_sale_price;
					@endphp
					<th width="150">Total Discount</th>
					<td>{{ ((100/$result->regular_price)*$remission) }} %</td>

					<th width="150">Remission</th>
					<td>{{ ($remission) }} tk</td>
				</tr>
			</table>
		</div>
		<div class="row">
			<div class="col-6 pl-0">
				<div class="row">
					@if(count($result->category)>0)
					<div class="col-6 pl-0">
						<table class="table">
							<caption class="text-left strong pl-1 pb-1">Category</caption>
							<tr>
								<th width="60">SL</th>
								<th>Name</th>
							</tr>
							@foreach($result->category as $key=>$value)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $value->name }}</td>
							</tr>
							@endforeach
						</table>
					</div>
					@endif

					@if(count($result->subcategory)>0)
					<div class="col-6">
						<table class="table">
							<caption class="text-left strong pl-1 pb-1">Sub Category</caption>
							<tr>
								<th width="60">SL</th>
								<th>Name</th>
							</tr>
							@foreach($result->subcategory as $key=>$value)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $value->name }}</td>
							</tr>
							@endforeach
						</table>
					</div>
					@endif

					@if(count($result->subsubcategory)>0)
					<div class="col-6">
						<table class="table">
							<caption class="text-left strong pl-1 pb-1">Sub Sub Category</caption>
							<tr>
								<th width="60">SL</th>
								<th>Name</th>
							</tr>
							@foreach($result->subsubcategory as $key=>$value)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $value->name }}</td>
							</tr>
							@endforeach
						</table>
					</div>
					@endif

					@if(count($result->color)>0)
					<div class="col-6">
						<table class="table">
							<caption class="text-left strong pl-1 pb-1">Colors</caption>
							<tr>
								<th width="60">SL</th>
								<th>Name</th>
							</tr>
							@foreach($result->color as $key=>$value)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $value->name }}</td>
							</tr>
							@endforeach
						</table>
					</div>
					@endif

					@if(count($result->size)>0)
					<div class="col-6">
						<table class="table">
							<caption class="text-left strong pl-1 pb-1">Sizes</caption>
							<tr>
								<th width="60">SL</th>
								<th>Name</th>
							</tr>
							@foreach($result->size as $key=>$value)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $value->name }}</td>
							</tr>
							@endforeach
						</table>
					</div>
					@endif
				</div>

			</div>
			@if(count($result->image) > 0)
			<div class="col-6 d-flex justify-content-center">
				<div class="image-wrapper">
					<div class="image">
						<img src="{{ asset($result->image[0]->medium ?? '') }}" class="responsive" alt="">
						<span class="color"></span>
					</div>
					<div class="avata-wrapper d-flex">
						<div class="avata">
							@foreach($result->image as $img)
							<div class="tamnil">
								<img src="{{ asset($img->smaller) }}" class="responsive" alt="">
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>

@endsection