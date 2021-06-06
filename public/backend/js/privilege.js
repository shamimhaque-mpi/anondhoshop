(()=>{

		window.addEventListener('load', ()=>{
			setTimeout(()=>{ 
				privilege();
			}, 10);
		});

		function objectToArray(obj){
			return Array.isArray(obj) ? obj : Object.values(obj);
		}

		function privilege()
		{
			let form 			= document.querySelector("form[name='privilege']");
			let token 			= document.querySelector("input[name='_token']").value;
			let user 			= document.querySelector('#user_id');
			let check_all 		= document.querySelector('#check_all');
			let menus 			= objectToArray(document.querySelectorAll('.menu'));
			let sub_menus 		= objectToArray(document.querySelectorAll('.sub-menu'));
			let action_menus 	= objectToArray(document.querySelectorAll('.action-menu'));

			user.addEventListener('click', ()=>{
				console.log(window.location.href+"/"+user.value);
				fetch(window.location.href+"/"+user.value)
				.then(inJson=>inJson.json())
				.then((data)=>{
					if(data){
						check_all.checked = false;
						menus.forEach((menu)=>{
							if(data.menu.indexOf(menu.value) > -1){
								menu.checked = true;
							}else{
								menu.checked = false;
							}

						});
						sub_menus.forEach((sub_menu)=>{
							if(data.sub_menu.indexOf(sub_menu.value) > -1){
								sub_menu.checked = true;
							}else{
								sub_menu.checked = false;
							}
						});
						action_menus.forEach((action_menu)=>{
							if(data.action_menu.indexOf(action_menu.value) > -1){
								action_menu.checked = true;
							}else{
								action_menu.checked = false;
							}
						});
					}else{
						menus.forEach((menu)=>{
							menu.checked = false;
						});
						sub_menus.forEach((sub_menu)=>{
							sub_menu.checked = false;
						});
						action_menus.forEach((action_menu)=>{
							action_menu.checked = false;
						});
					}
				})
				.catch((error) => {
				  console.error('Error:', error);
				  // window.location.reload();
				});
			});

			// Menu Event
			menus.forEach((menu)=>{
				menu.addEventListener('click', ()=>{
					if(!menu.checked){
						objectToArray(menu.closest('.position-relative').querySelectorAll("input[type='checkbox']"))
						.forEach((single_box)=>{
							single_box.checked = false;
						});
					}
				});
			});

			// Check sub menu
			sub_menus.forEach((sub_menu)=>{
				sub_menu.addEventListener('click', ()=>{
					if(!sub_menu.checked){
						let all_checkbox = objectToArray(sub_menu.closest('.position-relative').querySelectorAll("input[type='checkbox']"));
						all_checkbox.forEach((checkbox)=>{
							checkbox.checked =false;
						});
					}
					else{
						sub_menu.closest('.position-relative').parentElement.closest('.position-relative').querySelector('.menu').checked = true;
					}
				});
			});

			// Check Action Menu
			action_menus.forEach((action_menu)=>{
				action_menu.addEventListener('click', ()=>{
					let parent = false;
					action_menus.forEach((action_menu_2)=>{
						if(action_menu_2.checked){
							parent = true;
						}
					});
					if(parent){
						action_menu.closest('.position-relative').querySelector(".sub-menu").checked = true;
						action_menu.closest('.position-relative').parentElement.closest('.position-relative').querySelector(".menu").checked = true;
					}
				});
			});

			// mark Button
			check_all.addEventListener('click', ()=>{
				if(check_all.checked == true){
					menus.forEach((menu)=>{
						menu.checked = true;
					});
					sub_menus.forEach((sub_menu)=>{
						sub_menu.checked = true;
					});
					action_menus.forEach((action_menu)=>{
						action_menu.checked = true;
					});
				}else{
					menus.forEach((menu)=>{
						menu.checked = false;
					});
					sub_menus.forEach((sub_menu)=>{
						sub_menu.checked = false;
					});
					action_menus.forEach((action_menu)=>{
						action_menu.checked = false;
					});
				}
			});

			// Form Submit
			form.addEventListener('submit', (event)=>{
				event.preventDefault();
				let action = form.getAttribute('action');

				if(action && token)
				{
					var menu_key_value 			= [];
					var sub_menu_key_value 		= [];
					var action_menu_key_value 	= [];
					var i 						= 0;
					let formData 				= new FormData();

					menus.forEach((menu)=>{
						if(menu.checked){
							menu_key_value[i] = menu.value;
							i++;
						}
					});

					formData.append('menu', JSON.stringify(menu_key_value));
					i=0;
					sub_menus.forEach((sub_menu)=>{
						if(sub_menu.checked){
							sub_menu_key_value[i] = sub_menu.value;
							i++;
						}
					});

					formData.append('sub_menu', JSON.stringify(sub_menu_key_value));
					i=0;
					action_menus.forEach((action_menu)=>{
						if(action_menu.checked){
							action_menu_key_value[i] = action_menu.value;
							i++;
						}
					});
					formData.append('action_menu', JSON.stringify(action_menu_key_value));
					formData.append('_token', token);
					formData.append('user_id', user.value);

					loader('off');
					fetch(action, {
						method 	: 'POST',
						body 	: formData,
					})
					.then(myJson=>myJson.json())
					.then(data=>{
						if(data){
							success("✔ Privilege Set Successful...");
							loader('off');
						}
						else{
							warning("❌ Sorry, Something Was Wrong...");
						}
					})
					.catch((error) => {
					  console.error('Error:', error);
					  // window.location.reload();
					});
					// console.log(menu_key_value, sub_menu_key_value, action_menu_key_value);
				}

			});
		}
	})()