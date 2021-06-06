<template>
	<div class="user-site-bar" v-if="isSiteBar">
		<div class="user-anvata">
			<div class="avata">
				<img :src="base_url+(userPicture ? userPicture : 'public/frontend/icon/user.svg')" class="responsive">
			</div>
			<h3>{{guardName}}</h3>
		</div>
		<div class="site-menu">
			<ul>
				<li><a href="#" @click="go('home')" :class="(active=='home'?'active':'')">Dashboard</a></li>
				<li><a href="#" @click="go('user/my_order')" :class="(active=='user/my_order'?'active':'')">My Order</a></li>
				<li><a href="#" @click="go('user/wishlist')" :class="(active=='user/wishlist'?'active':'')">WishList</a></li>
				<li><a href="#" @click="go('user/settings')" :class="(active=='user/settings'?'active':'')">Settings</a></li>
				<li v-if="device!='mobile'"><a :href="base_url+'logout'">Logout</a></li>
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		name  : 'UserMenu',
		props : {
			name 	: [String],
			type 	: [String]
		},
		data(){
			return {
				base_url	: '',
				isSiteBar	: false,
				device 		: '',
				routes 		: ['home', 'user/my_order', 'user/wishlist', 'user/settings'],
				active 		: 'home',
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.device   = this.$store.state.device;
			this.active   = this.$store.state.uri;
			this.$store.state.guard_name = this.name;
			this.isVisible();
		},
		methods:{
			isVisible:function(){
				if(this.device == "mobile" && this.type=='nav'){
					this.isSiteBar = true;
				}
				else if(this.device != "mobile" && this.type=='panel'){
					this.isSiteBar = true;					
				}
			},
			go:function(target){
				window.event.preventDefault();
				this.$helper.mobileMenu();
				if((Object.values(this.routes)).indexOf(this.active) > -1){
					this.active = target;
					this.$store.state.uri = target;
					var newurl = this.base_url+target;
					window.history.pushState({path:newurl}, '', newurl);
				}
				else{
					window.location.href = this.base_url+target;
				}
			}
		},
		computed:{
			userPicture:function(){
				return this.$store.state.user_pic;
			},
			guardName:function(){
				return this.$store.state.guard_name;
			}
		}
	}
</script>