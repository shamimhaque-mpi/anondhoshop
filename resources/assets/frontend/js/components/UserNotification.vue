<template>
	<div class="user-action user-action-mobile align-self-center">
		<a href="#" class="home" title="Go Home">
			<span class="svg-icon">
				<img :src="base_url+'public/frontend/icon/home.svg'">								
			</span>
		</a>

		<a :href="base_url+'user/cart'" title="Click To Open Cart">
			<span class="svg-icon">
				<img :src="base_url+'public/frontend/icon/shopping-cart.svg'">
			</span>
			<span class="edge">{{cart}}</span>
		</a>

		<a href="#" id="notification_btn" title="Show Notification">
			<span class="svg-icon">
				<img :src="base_url+'public/frontend/icon/notification.svg'">								
			</span>
			<span class="edge">0</span>
		</a>

		<a :href="base_url+'user/wishlist'" title="Click To Open Wish List">
			<span class="svg-icon">
				<img :src="base_url+'public/frontend/icon/hart.svg'">	
			</span>
			<span class="edge">{{wishList}}</span>
		</a>


		<a href="#" v-if="isLogin" class="user-profile user_profile" title="">
			<img :src="base_url+(userPicture ? userPicture : 'public/frontend/icon/user.svg')">
		</a>

		<a :href="base_url+'login'" v-else class="user-profile" title="">
			<img :src="base_url+'public/frontend/icon/add-user.svg'">
		</a>

	</div>
</template>

<script>
	export default {
		name : 'UserNotification',
		data(){
			return {
				base_url : '',
				isLogin  : false,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.isLogin  = this.$store.state.isLogin;
			this.wishListIds();
			this.checkCart();
		},
		methods:{
			wishListIds:function(){
				if(this.isLogin){
					axios.post(this.base_url+'user/ajax/wishlist-ids')
					.then(response=>{
						this.$store.state.wishList = response.data;
					})
					.then(err=>console.log(err));
				}
			},
			checkCart:function(){
				let cart = window.localStorage.cart;
				if(cart){
					this.$store.state.cart 		= JSON.parse(cart);
					this.$store.state.cartKeys  = Object.keys(JSON.parse(cart));
				}
			}
		},
		computed:{
			wishList:function(){
				return (this.$store.state.wishList).length;
			},
			cart:function(){
				return (this.$store.state.cartKeys).length;
			},
			userPicture:function(){
				return this.$store.state.user_pic;
			}
		}
	}
</script>