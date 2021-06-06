<template>
	<div class="profiles" id="profile">
		<div class="profile_img">
			<img v-if="profile_pic" :src="url+'/'+profile_pic" alt="Admin">
		</div>
		<!-- ======= User Tools Box ========= -->
		<div class="profiles_option" id="profile_option">
			<div class="profiles_option_wrapper">
				<div class="user">
					<div class="img">
						<img v-if="profile_pic" :src="url+'/'+profile_pic" alt="Admin">
					</div>
					<div class="info">
						<h3>{{ name }}</h3>
						<p>#{{ username }}</p>
					</div>
				</div>
				<span class="divider"></span>
				<div class="btn-group float-right">
					<a :href="admin_profile" class="btn" title="Settings"><i class="fa fa-cogs" aria-hidden="true"></i></a>
					<a v-if="(admin_type == 'superadmin' || admin_type == 'developer')" :href="all_admins" class="btn" title="Users"><i class="fa fa-users" aria-hidden="true"></i></a>
					<a :href="logout_link" class="btn" title="Log-out"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		Name:'UserOption',
		props:['username', 'logout_link', 'all_admins', 'admin_profile'],
		data(){
			return {
				url 		: '',
				admin_type 	: '',
			}
		},
		mounted(){
			this.url 		= this.$store.state.site_url;
			this.admin_type = this.$store.state.admin_type;
		},
		computed:{
			profile_pic:function(){
				return this.$store.state.admin_photo;
			},
			name:function(){
				return this.$store.state.admin_name;
			}
		},
	}
</script>