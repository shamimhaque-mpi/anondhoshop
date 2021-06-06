class Slider {
	constructor() {
		// console.log("S Slider v-1.0");
		Slider.slider();
	}
	static slider() 
	{
		/*
		 * *********************
		 *	Get All Slider 
		 *	Parent Devision
		 * *******************
		*/
		let s_slider_wrappers = this.query('.s-slider-wrapper', 'all');
		if(s_slider_wrappers)
		{
			s_slider_wrappers.forEach((s_slider_wrapper, s_slider_wrapper_key)=>{
				Slider.setWidthOfItemContainer(s_slider_wrapper, s_slider_wrapper_key);
			});			
		}
	}
	/*
	 * *******************
	 *	Set Width Of 
	 *	item container
	 * *****************
	*/
	static setWidthOfItemContainer(s_slider_wrapper, s_slider_wrapper_key) 
	{
		let item = s_slider_wrapper.querySelector('.s-item-container').children;
		if((item.length)>0){
			let slider_width 	= s_slider_wrapper.clientWidth;
			let total_item		= s_slider_wrapper.firstElementChild.childElementCount;
			let all_items		= s_slider_wrapper.firstElementChild.children;
			let filter 			= '';

			// Set Item container width
			s_slider_wrapper.firstElementChild.style.width = (slider_width * total_item)+"px"; 
			// Set Item width
			all_items = this.ObToAr(all_items);
			all_items.forEach((item)=>{
				item.style.width = slider_width+"px";
			});

			/*
			 * **********************
			 * 	Set filter Botton
			 * ********************
			*/
			this.setFilter(s_slider_wrapper, s_slider_wrapper_key, total_item);


			/*
			 * **********************
			 * 	Stard Sliding
			 * ********************
			*/
			setTimeout(function(){
				Slider.sliding(s_slider_wrapper_key, slider_width, total_item);
			}, 10);
		}
		
	}

	/*
	 * *******************
	 *	Set Filter and 
	 *	Run Event
	 * *****************
	*/
	static setFilter(s_slider_wrapper, s_slider_wrapper_key, total_item)
	{
		this.ObToAr(s_slider_wrapper.children).forEach((container)=>{
			if(container.classList.contains('filter')){
				let content =  ``;
				for(let i=0; i < total_item; i++ ){
					content += `<span></span>`;				
				}
				container.innerHTML = content;
			}
		});
	}


	/*
	 * **********************
	 * 	Stard Sliding
	 * ********************
	*/
	static sliding(s_slider_wrapper_key, slider_width, total_item)
	{
		let s_slider_wrapper = this.query('.s-slider-wrapper', 'all')[s_slider_wrapper_key];

		let container 	= s_slider_wrapper.firstElementChild;
		let total_width = (slider_width * total_item);

		let position = -slider_width;
		let index	 = 1;

		let filter_btn = this.query('.filter'); filter_btn = (filter_btn ? this.ObToAr(filter_btn.children) : '');
			filter_btn[index-1].classList.add('active');
			Object.assign(container.style, {
				transform :`translate3d(${ ((position*index) + slider_width)}px, 0px, 0px)`,
			});

		setInterval(()=>{
			index++;
			if(index > total_item){
				index = 1;
				filter_btn[total_item-1].classList.remove('active')
			}
			else{
				filter_btn[index-2].classList.remove('active')
			}
			filter_btn[index-1].classList.add('active');

			Object.assign(container.style, {
				transform :`translate3d(${ ((position*index) + slider_width)}px, 0px, 0px)`,
			});

		}, 7000);
	}
	/*
	 * *******************
	 *	Convert Object 
	 *	To Array
	 * *****************
	*/
	static ObToAr(x){
		return Array.isArray(x) ? x : Object.values(x);
	}


	/*
	 * *********************
	 *	fetching document
	 *	Elements
	 * *****************
	*/
	static query(x, type=''){
		let elements = x;
		if(type == 'all'){
			elements = this.ObToAr(document.querySelectorAll(x));
		}
		else{
			elements = document.querySelector(x);
		}
		return elements;
	}
}

// window.addEventListener('load', ()=>{
	new Slider();	
// });