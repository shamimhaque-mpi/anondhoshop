(()=>{
	// Call Calculate Methods When Loading Complate
	// window.addEventListener('load', ()=>{// Append Main Content
		let alert_box_main_div 	= document.createElement('div');
		let alert_box_attr 		= document.createAttribute('class');
		let documentBody		= document.querySelector('body');
		let alert_box_content	= ``;

		alert_box_attr.value = "alert-box d-none";
		alert_box_main_div.setAttributeNode(alert_box_attr);

		let href 	 = window.location.href;
		let site_url = window.location.origin;

		if(href.search('localhost') > -1){
			site_url = site_url+'/'+href.slice(
				href.indexOf('localhost/') + "localhost/".length, href.indexOf('/', href.indexOf('localhost/') + "localhost/".length)
			);
		}


		alert_box_content = `
			<div class="alert">
				<div class="icon">
					<img src="${site_url}/public/backend/img/alert.png" alt="Warning">
				</div>
				<div class="title">
					<strong>Are you Sure Delete This Data..?</strong>
				</div>
				<div class="action">
					<button type="button" class="alert-exccept">Yes</button>
				</div>
				<div class="alert-close">
					<span>&times;</span>
				</div>
			</div>
		`;
		alert_box_main_div.innerHTML = alert_box_content;
		documentBody.appendChild(alert_box_main_div);
		AlertBox();
	// });

	// Main Calculate Methods
	function AlertBox() {
		var delete_alerts 	= document.querySelectorAll('.delete-alert');
		var alert_box 		= document.querySelector('.alert-box');
		var all_href		= []; 
		var terget_tag_key 	= '';

		if(delete_alerts)
		{
			delete_alerts = Array.isArray(delete_alerts) ? delete_alerts : Object.values(delete_alerts);
			delete_alerts.forEach((value, key)=>{

				// Store all href
				all_href[key] = value.href;
				if(value.dataset.protected == 'on'){
					value.removeAttribute('href');
					value.style.cursor = "pointer";
				}

				// Check Node
				if(value.nodeName == "A"){
					value.addEventListener('click', (event)=>{
						event.preventDefault();
						terget_tag_key = key;
						// Show Alert Box
						ShowAlert();
					});
				}
			});

			// Alert box except condition methods
			function AlertExccept(){
				let Exc_cond_btn = document.querySelector('.alert-exccept');
				if(Exc_cond_btn){
					Exc_cond_btn.addEventListener('click', ()=>{

						// Alert box hidden
						HiddenAlert();

						// Redirect to target location
						window.location.href = all_href[terget_tag_key];
						
						// You Can Open Here Anything Else
						/*
						 * ****************
						 * Code
						 * ***********
						*/ 
						loader('on');
					});
				}
			}
			AlertExccept();


			// Show Alert Box
			function ShowAlert(){
				if(alert_box.classList.contains('d-none')){
					alert_box.classList.remove('d-none');
				}
			}
 
			// Alert Box hidden
			function HiddenAlert(){
				if(alert_box){
					alert_box.classList.add('d-none');
				}
			}

			// Close Alert Box
			function CloseAlert(){
				let close = document.querySelector('.alert-close');
				close.onclick=()=>{
					alert_box.classList.add('d-none');	
					loader('off');			
				}
				window.addEventListener('click', (event)=>{
					let target = event.target;
					if(!target.closest('.alert') && target.closest('.alert-box')) {
						alert_box.classList.add('d-none');
						loader('off');
					}
				});
			}
			CloseAlert();
		}
	}
})()