@extends('backend.layouts.app')

@section('title', 'SubCategory')

@section('style')
	<style>
		.slider-title {
		    padding: 6px;
		    width: 245px;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		}
		.g-image{
			padding: 2px;
		}
		.form {
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    transform: translate(-50%, -50%);
		    width: 600px;
		    height: 339px;
		}
		.slider-edit {
			position: absolute;
		    width: 100%;
		    height: 90vh;
		    background: rgb(0, 0, 0, 0.4);
		    top: 0;
		    left: 0;
		}
		.close-btn{
			position: absolute;
		    top: 15px;
		    right: 15px;
		    padding: 5px 10px;
		    background: #fff;
		    border: 1px solid #9e9090;
		    cursor: pointer;
		}
		.submit{
			font-size: 21px;
	    	padding: 8px 23px;
		}
	</style>
@endsection

@section('content')
<div class="panel min-height-90  position-relative">
	<div class="panel-title d-flex space-between">
		<h2 class="align-self-center title"><i class="fa fa-plus"></i>&nbsp; Sub Category</h2>
	</div>
	<sub-category></sub-category>	
</div>

@endsection
