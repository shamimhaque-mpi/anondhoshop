<template>
	
</template>

<script>
	export default {
		name:"Master",
		props:['site_url', 'uri', 'is_login', 'user_pic'],
		mounted(){
			this.$store.state.base_url 	= this.site_url;
			this.$store.state.uri 		= this.uri;
			this.$store.state.isLogin 	= this.is_login;
			this.$store.state.user_pic 	= this.user_pic;
			this.device();
			this.getMonth();
			this.windowScroll();
		},
		methods:{
			device:function(){
				let width = window.innerWidth;
				if(width <= 768){
					this.$store.state.device = 'mobile';
				}
			},
			getMonth:function(){
				this.$store.state.months = {
					January 	: 31,
					February 	: 28,
					March 		: 31,
					April 		: 30,
					May 		: 31,
					June 		: 30,
					July 		: 31,
					August 		: 31,
					September 	: 30,
					October 	: 31,
					November 	: 30,
					December 	: 31,
				};
			},
			windowScroll:function(){
				window.addEventListener('scroll', ()=>{
					if(this.$store.state.winScroll=='off'){
						window.scrollTo(this.$store.state.scrollX, this.$store.state.scrollY);
					}
				});
			}
		}
	}
</script>