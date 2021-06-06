window.onload=()=>{
	/*
	* =====================
	* sidebar script
	* =================
	*/
	(()=>{
		let ParentMenus = document.querySelectorAll(".sidemenu>ul>li");
		if(ParentMenus){
			ParentMenus.forEach(function(value,key){
			  // ul>li>a
			  if(value.classList.contains('dropdown') && value.classList.contains('active')){
			    value.classList.add("dropdown-open");
			    value.children[1].style.height = value.children[1].scrollHeight+"px";
			  }
			  value.children[0].onclick=(event)=>{
			    ParentMenus.forEach(function(value2, key2){
			      if(value2.classList.contains('dropdown') && key2 != key){
			        value2.classList.remove("dropdown-open");
			        value2.children[1].style.height = "0px";
			      }
			    });
			    if(value.classList.contains('dropdown')){
			        if(value.classList.contains('dropdown-open')){
			          value.classList.remove("dropdown-open");
			          value.children[1].style.height = "0px";
			        }else{
			          value.classList.add("dropdown-open");
			          value.children[1].style.height = value.children[1].scrollHeight+"px";
			        }
			    }
			  }
			});
		}
	})();

	/*
	* ==========================
	* User Profile script
	* ======================
	*/
	(()=>{
		let profile = document.querySelector('#profile');
		let profile_option = document.querySelector('#profile_option');
		// click to botton
		if(profile){
			profile.onclick = function(event){
				if(profile_option.classList.contains('profile_option_open') && event.target.closest('#profile_option') == null){
					profile_option.classList.remove('profile_option_open');
				}else{
					profile_option.classList.add('profile_option_open');
				}
			}
			
		}
	})();

	/*
	* ============================
	* User notification script
	* =========================
	*/
	(()=>{
		let notification_box = document.querySelector('#notification_box');
		if(notification_box){
			let notification = document.querySelector('#notification');
			notification_box.onclick = function(event){
				if(notification.classList.contains("notification_open") && event.target.closest("#notification") == null){
					notification.classList.remove("notification_open");
				}else{
					notification.classList.add("notification_open");
				}
			}
		}
	})();

	/*
	* ============================================
	* mobile response sidebar toggle button
	* ========================================
	*/
	(()=>{
		let tg_btn = document.querySelector('.ToggleButton');
		let sidemenu = document.querySelector('.sidemenu');
		if(tg_btn && sidemenu){
			if(window.innerWidth <= 760){
				tg_btn.addEventListener('click', ()=>{
					if(tg_btn.classList.contains('close'))
					{
						tg_btn.classList.remove('close');
						sidemenu.classList.remove('sidebar-open');
					}
					else{
						tg_btn.classList.add('close');
						sidemenu.classList.add('sidebar-open');
					}
				});
			}
		}
	})();

	/*
	* =============================
	* Action button manage
	* ========================
	*/
	window.bottonManage=function(){
		//trash button
		let trashButton = document.querySelectorAll('.btn-trash');
		if(trashButton){
			trashButton = Array.isArray(trashButton) ? trashButton : Object.values(trashButton);
			trashButton.forEach(function(value, key){
				value.innerHTML = `<span><i class="fa fa-trash" aria-hidden="true"></i></span>`;
				if(!value.hasAttribute('title')){
					value.setAttribute('title','trash Data');
				}
				value.classList.add('bg-warning');
			});
		}
		//delete button
		let deleteButton = document.querySelectorAll('.btn-delete');
		if(deleteButton){
			deleteButton = Array.isArray(deleteButton) ? deleteButton : Object.values(deleteButton);
			deleteButton.forEach(function(value, key){
				value.innerHTML = `<span><i class="fa fa-times" aria-hidden="true"></i></span>`;
				if(!value.hasAttribute('title')){
					value.setAttribute('title','Delete Data');
				}
				value.classList.add('bg-danger');
			});
		}
		//edit button
		let editButton = document.querySelectorAll('.btn-edit');
		if(editButton){
			editButton = Array.isArray(editButton) ? editButton : Object.values(editButton);
			editButton.forEach(function(value, key){
				value.innerHTML = `<span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>`;
				if(!value.hasAttribute('title')){
					value.setAttribute('title','Edit Data');
				}
				value.classList.add('bg-success');
			});
		}
		//view button
		let viewButton = document.querySelectorAll('.btn-view');
		if(viewButton){
			viewButton = Array.isArray(viewButton) ? viewButton : Object.values(viewButton);
			viewButton.forEach(function(value, key){
				value.innerHTML = `<span><i class="fa fa-eye" aria-hidden="true"></i></span>`;
				if(!value.hasAttribute('title')){
					value.setAttribute('title','View Data');
				}
				value.classList.add('bg-info');
			});
		}
		//view block
		let blockButton = document.querySelectorAll('.btn-block');
		if(blockButton){
			blockButton = Array.isArray(blockButton) ? blockButton : Object.values(blockButton);
			blockButton.forEach(function(value, key){
				value.innerHTML = `<span><i class="fa fa-ban" aria-hidden="true"></i></span>`;
				if(!value.hasAttribute('title')){
					value.setAttribute('title','Block');
				}
				value.classList.add('bg-danger');
			});
		}
	};
	bottonManage();


	/*
	* =============================
	* When click on window 
	* then do something
	* ========================
	*/
	window.onclick=(event)=>{
		//user profile
		if(event.target.closest('#profile') == null){
			let profile_option = document.querySelector('#profile_option');
			if(profile_option && profile_option.classList.contains('profile_option_open')){
				profile_option.classList.remove('profile_option_open')
			}
		}
		//notification
		if(event.target.closest('#notification_box') == null){
			let notification = document.querySelector('#notification')
			if(notification && notification.classList.contains('notification_open')){
				notification.classList.remove('notification_open')
			}
		}
	}
}

// Loader Control
function loader(x){
	var loader = document.querySelector('.loader');
	// Loader on
	if(x == 'on' && loader && loader.classList.contains('loader_off')){
		loader.classList.remove('loader_off');
	}

	// Loader off
	else if(x == 'off' && loader){
		loader.classList.add('loader_off');
	}

	return x;
}