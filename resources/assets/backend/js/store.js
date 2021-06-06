import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		site_url 	:'',
		admin_photo :'',
		admin_name  :'',
		admin_type  :'',
	},
	getters: {
		formData:(state)=>(x)=>{
			let formdata = new FormData();
			for(const key in x){
				formdata.append(key, x[key]);
			}
			return formdata;
		},
		arrayValueRemove:(state)=>(arr, index)=>{
			let temp = [];
			for(const key in arr){
				if(key != index){
					temp.push(arr[key]);
				}
			}
			return temp;
		}
	},
	mutations :{}
});