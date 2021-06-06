(()=>{
	window.addEventListener('load', ()=>{
		let loader = document.querySelector('.loader');
		if(loader){
			loader.className += ' loader_off';
		}
	});

	// all ancor tag action event
	window.addEventListener('load', ()=>{
		let ancors = document.querySelectorAll('a');
		if(ancors.length > 0){
			ancors = Array.isArray(ancors) ? ancors : Object.values(ancors);
			ancors.forEach((value)=>{
				value.addEventListener('click', function()
				{
					let loader = document.querySelector('.loader');
					if(value.href != '' && loader && loader.classList.contains('loader_off')){
						loader.classList.remove('loader_off');
					}
				});
			});
		}
	});

})()

window.onload=()=>{
	/*
	* *********************************
	* The Following Method Manage 
	* The Input Field
	* ****************************
	*/
	(()=>{
		let pass 	  = document.querySelector("#password");
		let btn  	  = document.querySelector("#show");
		let icon	  = btn.children[0];
		let dondition = true;
		if(pass && btn)
		/* add Event on the show button */
		btn.addEventListener("click", toShow);

		function toShow(){
			if(dondition){
				icon.classList.remove("fa-eye");
				icon.classList.add("fa-eye-slash");
				pass.setAttribute("type", "text");
				dondition = false;
			}else{
				icon.classList.remove("fa-eye-slash");
				icon.classList.add("fa-eye");
				pass.setAttribute("type", "password");
				dondition = true;
			}
		}
	})();
	/*
	* *********************************
	* The Following Method validate 
	* The Input Field
	* ****************************
	*/
	(()=>{
		let username = document.querySelector('#username');
		let password = document.querySelector('#password');
		if(document.forms.length > 0){
			let loginform = document.forms.item(0);
			loginform.onsubmit = (event)=>{
				if(username.value == ''){
					username.parentElement.classList.add('unvalidated');
				}
				else{
					username.parentElement.classList.remove('unvalidated');
				}
				if(password.value == ''){
					password.parentElement.classList.add('unvalidated');
				}else{
					password.parentElement.classList.remove('unvalidated');
				}
				if(username.value == '' || password.value == ''){
					event.preventDefault();					
				}else{
					let loader = document.querySelector('.loader');
					if(loader){
						loader.className = 'loader';
					}
				}
			}
		}
		username.addEventListener('keyup', ()=>{
			if(username.value == ''){
				username.parentElement.classList.add('unvalidated');
			}else{
				username.parentElement.classList.remove('unvalidated');
			}
		});
		password.addEventListener('keyup', ()=>{
			if(password.value == ''){
				password.parentElement.classList.add('unvalidated');
			}else{
				password.parentElement.classList.remove('unvalidated');
			}
		});

	})();
}

