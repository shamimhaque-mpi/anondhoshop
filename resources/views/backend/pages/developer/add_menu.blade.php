@extends('backend.layouts.app')

@section('title', 'Demo-Developer')

@section('content')
	<menu-add
		fetch_url		= "{{ route('deleveoper.menu.fetch') }}"
		store_url		= "{{ route('developer.menu.store') }}"
		csrf			= "{{ csrf_token() }}"
		menu_list		= "{{ route('developer') }}"
		fontawesomes	= "{{ $fontawesome }}"
	></menu-add>
@endsection

@section('script')
@endsection
