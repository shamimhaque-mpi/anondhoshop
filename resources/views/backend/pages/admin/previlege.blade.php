@extends('backend.layouts.app')

@section('title', 'Admin-List')

@section('style')
	<style>
		.panel {
			user-select: none;
		}
		._sub-menu::before {
		    content: '';
		    width: 10px;
		    height: 12px;
		    position: absolute;
		    top: 28px;
		    left: 32px;
		    border: 1px solid black;
		    border-top: none;
		    border-right: none;
		}
		._sub-menu::after {
		    content: '';
		    width: 7px;
		    height: 7px;
		    position: absolute;
		    top: 36px;
		    left: 34px;
		    border: 1px solid black;
		    transform: rotate(-45deg);
		    border-top: none;
		    border-left: none;
		}
		._action-menu::before {
		    content: '';
		    width: 10px;
		    height: 12px;
		    position: absolute;
		    top: 24px;
		    left: 27px;
		    border: 1px solid black;
		    border-top: none;
		    border-right: none;
		}
		._action-menu::after {
		    content: '';
		    width: 7px;
		    height: 7px;
		    position: absolute;
		    top: 32px;
		    left: 29px;
		    border: 1px solid black;
		    transform: rotate(-45deg);
		    border-top: none;
		    border-left: none;
		}
	</style>
@endsection


@section('content')
	<div class="panel">
		<div class="panel-title">
			<h2><span><i class="fa fa-expeditedssl"></i></span>&nbsp;Privilege</h2>
		</div>
		<form action="{{ route('admin.setUser.privilege') }}" method="POST" name="privilege">
			@csrf
			<div class="panel-body pt-3">
				<div class="row d-flex space-between">
					@if(!$menus->isEmpty())
					<div class="col-3 p-0">
						<div class="card"><label><input type="checkbox" id="check_all">&nbsp;Check All</label></div>
					</div>
					@endif
					<div class="col-3 p-0">
						<div class="form-group p-0">
							<select name="user_id" class="form-control select2" id="user_id" required="true">
								<option selected="true" disabled="true">Select a User</option>
								@foreach($admins as $key=>$admin)
									<option value="{{ $admin->id }}">{{ $admin->username }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<!-- Menu Section -->
				@if(!$menus->isEmpty())
					@foreach($menus as $key=>$menu)
					<div class="card mb-2">
						<div class="row">
							<div class="col-12 position-relative">
								<label class=""><input type="checkbox" name="menu[]" value="{{ $menu->id}}" class="menu">&nbsp;{{ (App::isLocale('en') ? $menu->name_en : $menu->name_bn) }}</label>
								@if(!$menu->SubMenus->isEmpty())
								<div class="d-flex mt-2 ml-5 pl-3 _sub-menu">
									<!-- Sub-menu -->
									@foreach($menu->SubMenus as $sub_key=>$SubMenu)
									<div class="position-relative">
										<label class="mr-2"><input type="checkbox" name="sub_menu[]" value="{{ $SubMenu->id }}" class="sub-menu">&nbsp;{{ (App::isLocale('en') ? $SubMenu->name_en : $SubMenu->name_bn) }}</label>	
										<!-- Action Menu -->
										@if(!$SubMenu->ActionMenus->isEmpty())
										<div class="d-flex mt-2 ml-5 pl-3 _action-menu">
											@foreach($SubMenu->ActionMenus as $action_key=>$ActionMenu)
											<label class="mr-2"><input type="checkbox" name="action_menu[]" value="{{ $ActionMenu->id }}" class="action-menu">&nbsp;{{ (App::isLocale('en') ? $ActionMenu->name_en : $ActionMenu->name_bn) }}</label>				
											@endforeach
										</div>	
										@endif		
										<!-- End Action Menu -->
									</div>	
									@endforeach						
									<!-- End Sub-menu -->
								</div>
								@endif
							</div>
						</div>
					</div>
					@endforeach
				@endif
				<!-- End Menu Section -->
				<div class="row mt-5">
					<div class="col-12 p-0 d-flex justify-content-end">
						<input type="submit" name="" class="btn btn-success">
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection

@section('script')
	<script src="{{ asset('public/backend/js/privilege.js') }}"></script>
@endsection