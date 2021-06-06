@extends('backend.layouts.app')

@section('title', 'Settings')

@section('style')
<style>
.logo {
	height: 287px;
	width: 100%;
	position: relative;
	overflow: hidden;
	display: flex;
	justify-content: center;
}
.logo img {
    width: inherit;
    height: fit-content;
    object-fit: cover;
    align-self: center;
}
.logo .file{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	cursor: pointer;
    transition: all .5s;
}
.logo .file:hover{
	background: #0000005c;
}
.logo .file input[type='file']{
	opacity: 0;
}
.logo .file::before {
    content: 'Upload';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    border-radius: 50%;
    box-sizing: border-box;
    border: 3px solid #2d6ef12e;
    color: #2d6ef12e;
    opacity: 1;
    text-align: center;
    line-height: 97px;
    font-weight: 900;
    transition: all .5s;
}
.logo .file:hover::before {
	border-color: #fff;
	color: #fff;
}
.fav-icon {
    height: 130px;
    width: 151px;
}
.submit-btn {
    padding: 10px 30px;
    margin-top: 20px;
    width: 90px;
}
</style>
@endsection

@section('content')
	<site-setting>
		
	</site-setting>
@endsection

