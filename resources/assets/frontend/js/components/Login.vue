<template>
	<div class="login-wrapper">
		<div class="login-panel">
			<div class="login-header">
				<h2>Welcome To {{site_name}}</h2>
				<a href="#" @click="switch_to">{{ (login ? 'Create An Account' : 'Login Your Account') }}</a>
			</div>

			<div class="form" v-if="login">
				<div class="icon">
					<img :src="base_url+'public/frontend/icon/look.webp'">
				</div>
				<div class="form-group">
					<label>Username/Mobile</label>
					<input type="text" class="form-control" v-model="username" placeholder="Please Enter Your Username/Mobile No">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" v-model="password" placeholder="Please Enter Your Password">
				</div>
				<div class="form-action">
					<a href="#">Forgot Your Password?</a>
					<button @click="submit">Login</button>
				</div>
			</div>

			<sign-up v-else 
				:site_name="site_name"
				@userPermit="userPermit"
			></sign-up>

		</div>
		<div class="others-login">
			<h4>Or, {{(login ? 'Login':'Sign Up')}} With</h4>
			<div class="regi_img">
				<img :src="base_url+'public/frontend/icon/regi.webp'">
			</div>
			<button>Facebook</button>
			<button>Twiter</button>
		</div>
	</div>
</template>

<script>
	import signup from './Signup';
	export default {
		name:'Login',
		components:{
			'sign-up': signup
		},
		props:{
			site_name	: [String],
			is_route	: [String],
			indend_url	: [String],
		},
		data(){
			return {
				base_url : '',
				login    : true,
				username : '',
				password : '',
			}
		},
		mounted(){
			this.base_url 	= this.$store.state.base_url;
			this.login 		= (this.is_route=='login'?true:false);
		},
		methods:{
			switch_to:function(event=null){
				(event ? event.preventDefault() : '');
				this.login 		= (this.login ? false : true);
				let title 		= (this.login ? "login" : "Registration");
				let path 		= (this.login ? "login" : "sign-up");
				this.username 	= '';
				this.password 	= '';
				window.history.pushState({page: true}, title, path);
			},
			userPermit:function(mobile){
				this.switch_to();
				this.username = mobile;
			},
			submit:function(){
				var username = this.username;
				var password = this.password;
				var data = {
					username : username,
					password : password,
				}
				if(username && password){
					axios.post(this.base_url+'login', data)
					.then(response=>{
						if(response.data){
							window.location.href=this.indend_url;
						}else{
							warning("❌ Your Username And Password Is Wrong ‼");
						}
					})
					.then(err=>console.log(err));
				}else{
					warning("❌ Username/Mobile And Password Field Is Required");
				}
			}
		}
	}
</script>