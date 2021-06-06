// My Class
import Vue from 'vue';
class OwnClass {
	constructor (){
		Vue.prototype.$custom = this.methods();
		this.default();
	}

	// Methods
	methods(){
		return {
			loader : (x)=>{
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
			},
			setMessage : (type, title)=>{
				window.localStorage.alertMessageType = type;
				window.localStorage.alertMessageTitle = title;
			},
			getMessage : ()=>{
				let type = window.localStorage.alertMessageType;
				let title = window.localStorage.alertMessageTitle;
				if(type != '' && title != ''){
					let vue = new Vue();
					if(type == 'success'){
						vue.$message.success(title);
					}
					else if(type == 'warning'){
						vue.$message.warning(title);
					}
					window.localStorage.removeItem('alertMessageType');
					window.localStorage.removeItem('alertMessageTitle');
				}
			}
		}
	}

	default(){
		window.process=(x)=>{
			if(x=='free'){
				document.body.style.cursor = "default";
			}
			else if(x=='busy'){
				document.body.style.cursor = "progress";
			}
		}
	}
}


export const custom = new OwnClass();