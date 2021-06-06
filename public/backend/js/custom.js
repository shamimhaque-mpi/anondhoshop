(()=>{
	/*
	 * ***********************
	 *	Base Url
	 * ********************
	*/
	let href 	 = window.location.href;
	let site_url = window.location.origin;

	if(href.search('localhost') > -1){
		site_url = site_url+'/'+href.slice(
			href.indexOf('localhost/') + "localhost/".length, href.indexOf('/', href.indexOf('localhost/') + "localhost/".length)
		);
	}
	window.site_url = site_url;

		
	window.addEventListener('load', ()=>{
	let loader = document.querySelector('.loader');
		if(loader){
			loader.className += ' loader_off'
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


	/*
	 * ==========================
	 * 	Default Image source
	 * =======================
	*/ 
	window.addEventListener('load', ()=>{
		let imges = Object.values(document.querySelectorAll("input[type='file']"));
		let views  = Object.values(document.querySelectorAll(".image-auto-load"));
		if(views){
			views.forEach((view)=>{
				console.log(view.src);
				if(view.nodeName == "IMG" && !(view.src.indexOf('.webp') > -1 || view.src.indexOf('.jpg') > -1 || view.src.indexOf('.jpeg') > -1 || view.src.indexOf('.png') > -1)){
					view.src = window.site_url+"/public/backend/img/fluid.svg" ;
				}
			});
		}
		if(imges){
			imges.forEach((image, key)=>{
				image.addEventListener('change', (event)=>{
					let file = event.target.files[0];
					if(views[key] && (views[0].nodeName == "IMG")){
						if(file && (file.type).search('image/') > -1)
						{
							views[key].src = URL.createObjectURL(file);
						}
						else{
							views[key].src = window.site_url+"/public/backend/img/fluid.svg";									
						}
					}
				});
			});
		}
	});
})()