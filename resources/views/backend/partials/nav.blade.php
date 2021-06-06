<div class="header">
	<div class="sidebarheader">
		<h1>{{ Auth::guard('admin')->user()->type }}</h1>
			<div class="ToggleButton">
				<span></span>
				<span></span>
				<span></span>
			</div>
	</div>
	<div class="task_bar">
		<!--  ================= Profiles Tools Menu ================ -->
		<div class="task_bar_menu">
			<div class="localization">
				<a href="{{ route('localization', (App::isLocale('en') ? 'bn' : 'en')) }}" title="Change Language">
					<img src="{{ asset('public/backend/icon/'.(App::isLocale('en') ? 'bn' : 'en').'_flag.webp') }}" alt="">
				</a>
			</div>
		</div>
		<!--  ==================== end Notification bar ================== -->
		<div class="task_bar_menu">
			<!-- ===================== Notification bar ==================== -->
			<div class="notification-box" id="notification_box">
				<div class="envelope">
					<span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
					<span class="smg_count">50</span>
				</div>
				<div class="notification" id="notification">
					<div class="notification-innerBox">
						<div class="ontification-mainBox">
							<!-- message -->
							<div class="message">
								<span>1</span><samp>This is first message</samp>
							</div>
							<div class="message">
								<span>2</span><samp>This is first message</samp>
							</div>
							<div class="message">
								<span>3</span><samp>This is first message</samp>
							</div>
							<div class="message">
								<span>4</span><samp>This is first message, but this not last message ok</samp>
							</div>
							<!-- end message -->
							<a href="#" class="link float-right text-info mt-1">See more</a>
						</div>
					</div>
				</div>
			</div>
		<!-- ================== end Notification bar =================== -->
		</div>
		<!--  ==================== end Notification bar ================== -->
		<!--  ================= start Profiles Tools Menu ================ -->
		<div class="task_bar_menu">
			<user-option
				username="{{ Auth::guard('admin')->user()->username }}"
				logout_link="{{ route('admin.logout') }}"
				all_admins ="{{ route('admin.all') }}"
				admin_profile = "{{ route('admin.profile') }}"
			></user-option>
		</div>
	<!--  ================= end Profiles Tools Menu ================ -->
	</div>
</div>