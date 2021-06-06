@extends('backend.layouts.app')

@section('title', 'Product/Add')


@section('style')
<style>
	.image {
	    width: 203px;
	    height: 203px;
	    padding: 3px;
	    border: 1px solid #ddd;
	    box-sizing: border-box;
	    position: relative;
	}
	.image .remove {
	    position: absolute;
	    top: 10px;
	    right: 10px;
	    padding: 5px 10px;
	    border: 1px solid #b7b7b7;
	    cursor: pointer;
	    transition: all .6s;
	    background: #fff;
	    color: #000;
	    border-radius: 3px;
	}
	.image .remove:hover{
		background: #ddd;
		color: #f00;
	}
	.submit{
		font-size: 21px;
    	padding: 8px 23px;
	}
	@media screen and (max-width: 576px){
		.image {
		    width: 170px;
		    height: 170px;
		}
	}
</style>
@endsection

@section('content')

<div class="panel min-height-90">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-plus"></i>&nbsp; Product Add</h2>
		<a href="{{ route('admin.product.list') }}" class="btn-sml bg-success">List</a>
	</div>
	<div class="panel-body">
		<product></product>
	</div>
</div>

@endsection
