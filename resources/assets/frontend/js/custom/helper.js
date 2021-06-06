import Vue from 'vue';
class Helper{
	constructor() {
		Vue.prototype.$helper = Helper.methods();
	}

	static menu(){
		var btn = document.querySelector('.front-site-btn');
		(btn ? btn.click() : '');
	}

	static methods(){
		return {
			mobileMenu:function(){
				if(window.innerWidth <= 768){
					Helper.menu();					
				}
			}
		}
	}
}
export const helper = new Helper();