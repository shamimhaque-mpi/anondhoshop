import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		guard_name 		: '',
		base_url 		: '',
		device 			: '',
		months			: '',
		isLogin 		: '',
		uri 			: '',
		user_pic 		: '',
		winScroll 		: 'on',
		scrollX 		: 0,
		scrollY 		: 0,
		wishList 		: [],
		cart 	 		: {},
		cartKeys 		: [],
		search_keywords : '',
	},
	getters: {
		removeProduct:(state)=>(x)=>{
			state.wishList = (state.wishList).filter(y=>{
				if(x!=y){
					return y;
				}
			});
		},
		winScroll:(state)=>(x)=>{
			if(x=='off'){
				state.winScroll = 'off';
				state.scrollX = window.scrollX;
				state.scrollY = window.scrollY;
			}else{
				state.winScroll = 'on';
			}
		}
	},
	mutations :{
		
	}
});