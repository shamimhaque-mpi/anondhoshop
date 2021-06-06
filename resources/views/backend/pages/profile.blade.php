@extends('backend.layouts.app')

@section('title', 'demo')

@section('style')
  <link rel="stylesheet" type="text/css" href="{{ asset('public/backend/css/user_profile.css') }}">
@endsection

@section('content')


<div class="panel min-height-90">
  <div class="panel-title">
    <h1><i class="fa fa-star-o"></i>&nbsp;<small>Profile</small></h1>
  </div>
  <div class="panel-body">
    {{-- Admin Profile Template --}}
    <admin-profile></admin-profile>
  </div>
</div>

@endsection

@section('script')

@endsection