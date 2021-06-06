(()=>{
	window.addEventListener('scroll', event=>{
		let header_sticky = document.querySelector('.header-sticky');
		if(header_sticky)
		{
			let top 	= header_sticky.getBoundingClientRect().top;
			let header  = document.querySelector('.header');
			let filter  = document.querySelector('.filter');
			let m_wrpr  = document.querySelector('.menu-wrapper');

			if(top <= 0 && header)
			{
				header.classList.add('sticky');
			}
			else if(header){
				header.classList.remove('sticky');
			}

			if(top <= 0 && filter){
				filter.classList.add('on-scroll');
			}
			else if(filter){
				filter.classList.remove('on-scroll');
			}

			if(top <= 0 && m_wrpr){
				m_wrpr.classList.add('on-scroll');
			}
			else if(m_wrpr){
				m_wrpr.classList.remove('on-scroll');
			}
		}

		// Close Search Field
		let search_field = document.querySelector("#search_field");
		if(search_field && search_field.classList.contains('show')){
			search_field.classList.remove('show');
		}

		// User Action box
		let user_log = document.querySelector("#user_log");
		if(user_log && user_log.classList.contains('show')){
			user_log.classList.remove('show');
		}

		// User notification
		let notification = document.querySelector("#notification");
		if(notification && notification.classList.contains('show')){
			notification.classList.remove('show');
		}
	});

	window.addEventListener('load',()=>{
		/*
		 * ******************
		 * Search Field
		 * ******************
		*/ 
		let search_field = document.querySelector('#search_btn');
		if(search_field){
			search_btn.addEventListener('click', (event)=>{
				event.preventDefault();
				let search_field = document.querySelector("#search_field");
				if(search_field && search_field.classList.contains('show')){
					search_field.classList.remove('show');
				}
				else if(search_field){
					search_field.classList.add('show');
					search_field.querySelector("input").focus();
				}
			});
		}
		/*
		 * ******************
		 * User Profile
		 * ******************
		*/ 
		let user_profile = document.querySelectorAll('.user_profile');
		if(user_profile){
			Object.values(user_profile).forEach((value)=>{
				value.addEventListener('click', (event)=>{
					event.preventDefault();
					let user_log = document.querySelector("#user_log");
					if(user_log && user_log.classList.contains('show')){
						user_log.classList.remove('show');
					}
					else if(user_log){
						user_log.classList.add('show');
					}
				});
			});
		}
		/*
		 * ******************
		 * User notification
		 * ******************
		*/ 
		let notification_btn = document.querySelector('#notification_btn');
		if(notification_btn){
			notification_btn.addEventListener('click', (event)=>{
				event.preventDefault();
				let notification = document.querySelector("#notification");
				if(notification && notification.classList.contains('show')){
					notification.classList.remove('show');
				}
				else if(notification){
					notification.classList.add('show');
				}
			});
		}
		/*
		 * ******************
		 * Action Menu Btn
		 * Of Mobile view
		 * ******************
		*/
		let front_site_btn = document.querySelector('.front-site-btn');
		let menu_wrapper = document.querySelector('.menu-wrapper');
		if(front_site_btn && menu_wrapper){
			front_site_btn.addEventListener('click', ()=>{
				if(front_site_btn.classList.contains('close')){
					front_site_btn.classList.remove('close');
					menu_wrapper.classList.remove('open');
				}else{
					front_site_btn.classList.add('close');
					menu_wrapper.classList.add('open');
				}
			});
		}
	});



	// Window Action Click
	window.addEventListener('click', (event)=>{

		/*
		 ************************************
		 * User Profile Action
		 ************************************
		*/
		if(!event.target.closest('.user-logbar') && !event.target.closest('.user_profile')){
			let user_log = document.querySelector("#user_log");
			if(user_log && user_log.classList.contains('show')){
				user_log.classList.remove('show');
			}
		}

		/*
		 ************************************
		 * Notification
		 ************************************
		*/
		if(!event.target.closest('#notification_btn') && !event.target.closest('#notification')){
			let notification = document.querySelector("#notification");
			if(notification && notification.classList.contains('show')){
				notification.classList.remove('show');
			}
		}
	});
})()