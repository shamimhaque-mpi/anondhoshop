@extends('backend.layouts.app')

@section('title', 'Demo-Developer')

@section('content')
	<menu-edit
		fetch_url		= "{{ route('deleveoper.menu.fetch') }}"
		update_url		= "{{ route('developer.menu.update') }}"
		s_m_fetch_url 	= "{{ route('deleveoper.sigle.menu.fetch') }}"
		csrf			= "{{ csrf_token() }}"
		menu_list   	= "{{ route('developer') }}"
		has_menu_type 	= "{{ $type }}"
		has_menu_id		= "{{ $id }}"
		fontawesomes	= "{{ $fontawesome }}"
	></menu-edit>
@endsection

@section('script')
@endsection
