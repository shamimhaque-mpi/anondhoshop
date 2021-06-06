<template>
	<div class="h100" title="Add To Wish List" @click="addToWishList">
		<div class="quick-icon">
			<img :src="base_url+'/public/frontend/icon/'+(wishList.indexOf(this.product_id)>-1 ? 'hart-red.svg' : 'hart.svg')">
		</div>
	</div>
</template>

<script>
	export default {
		name: 'AddToWishList',
		props:{
			product_id	: [Number],
		},
		data(){
			return {
				base_url 	: '',
			}
		},
		mounted(){
			this.base_url 	 = this.$store.state.base_url;
		},
		methods:{
			addToWishList:function(event){
				event.preventDefault();
				if(this.$store.state.isLogin){
					axios.post(this.base_url+'user/ajax/add-to-wishlist', {
						product_id : this.product_id 
					})
					.then(reponse=>{
						this.$store.state.wishList = reponse.data; 
						this.product_ids = reponse.data;
					})
					.then(err=>console.log(err));
				}
				else{
					window.location.href=this.base_url+'login';
				}
			}
		},
		computed:{
			wishList:function(){
				return this.$store.state.wishList;				
			}
		}
	}
</script>