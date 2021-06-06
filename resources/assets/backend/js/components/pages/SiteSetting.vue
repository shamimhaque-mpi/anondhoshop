<template>
<div class="panel">
	<div class="panel-title">
		<h2 class="title"><i class="fa fa-gears"></i>&nbsp;Site Settings</h2>
	</div>
	<div class="panel-body">
		<div class="row">
		    <div class="col-12">
		        <div class="fieldset">
		          	<div class="legend">
		            	<h4><span><i class="fa fa-link"></i></span>&nbsp;Site Inoformation</h4>
		          	</div>
		          	<div class="row">
			        	<div class="col-6">
			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-envira"></i></span>&nbsp;Site Name</label>
			        			<input type="text" v-model="site_name" class="form-control" name="" placeholder="Ex:Annondho Shop">
			        		</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-scissors"></i></span>&nbsp;Title Prefix</label>
			        			<input type="text" v-model="title_prefix" class="form-control" name="" placeholder="Example">
			        		</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-phone-square"></i></span>&nbsp;Phone</label>
			        			<input type="text" v-model="mobile" class="form-control" name="" placeholder="+880">
			        		</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-facebook-square"></i></span>&nbsp;Facebook</label>
			        			<input type="text" v-model="facebook" class="form-control" name="" placeholder="Facebook.com">
			        		</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-youtube"></i></span>&nbsp;Youtube </label>
			        			<input type="text" v-model="youtube" class="form-control" name="" placeholder="Youtube.com">
			        		</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-twitter-square"></i></span>&nbsp;Twitter </label>
			        			<input type="text" v-model="twitter" class="form-control" name="" placeholder="Twitter.com">
			        		</div>
			        	</div>

						<div class="col-6">
				        	<div class="form-group"> 
					          	<label for="" class="label">Short Discription</label>
					          	<textarea name="" v-model="description" class="form-control" style="min-height: 196px;" placeholder="Write Your Short Desciption"></textarea>
				          	</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-linkedin-square"></i></span>&nbsp;Linkedin </label>
			        			<input type="text" v-model="linkedin" class="form-control" name="" placeholder="Linkedin.com">
			        		</div>

			        		<div class="form-group">
			        			<label for="" class="label"><span><i class="fa fa-google-plus-square"></i></span>&nbsp;E-mail </label>
			        			<input type="text" v-model="mail" class="form-control" name="" placeholder="Some@mail.com">
			        		</div>

					        <div class="form-group d-flex justify-content-end"> 
					          	<div class="btn-group">
					          		<button type="button" @click="submit" class="btn bg-success float-right submit-btn"><i :class="icon"></i> </button>
					          	</div>
					        </div>
				        </div>
		          	</div>
		        </div>
			</div>


			<div class="col-4">
		        <div class="fieldset">
		          <div class="legend">
		            <h4>Logo</h4>
		          </div>
		          <div class="logo border">
		          	<label class="file">
		          		<input type="file" name="" @change="sitLogo">
		          	</label>
		          	<img v-if="logo" :src="url+logo" alt="">
		          </div>
		        </div>
			</div>

			<div class="col-3">
		        <div class="fieldset">
		          <div class="legend">
		            <h4>Fav Icon</h4>
		          </div>
		          <div class="logo fav-icon border">
		          	<label class="file">
		          		<input type="file" name="" @change="favIcon">
		          	</label>
		          	<img v-if="fav_icon" :src="url+fav_icon" alt="">
		          </div>
		        </div>
			</div>

		</div>
	</div>
</div>
</template>

<script>
	export default {
		name: 'SiteSetting',
		data(){
			return {
				title_prefix: '',
				facebook	: '',
				mobile		: '',
				youtube		: '',
				twitter		: '',
				site_name 	: '',
				linkedin	: '',
				mail		: '',
				description : '',
				fav_icon	: '',
				logo 		: '',
				url 		: '',
				response	: [],
				icon 		: 'fa fa-check-square-o fa-2x',
			}
		},
		mounted(){
			this.url = this.$store.state.site_url+'/';

			axios.post(this.url+'admin/settings/getData')
			.then(response=>{
				let data 			= response.data;
				if(data){
					this.title_prefix 	= data.title_prefix;
					this.facebook 		= data.facebook;
					this.mobile 		= data.mobile;
					this.youtube 		= data.youtube;
					this.twitter 		= data.twitter;
					this.linkedin 		= data.linkedin;
					this.mail 			= data.mail;
					this.description 	= data.description;
					this.fav_icon 		= data.fav_icon;
					this.logo 			= data.logo;
					this.site_name 		= data.site_name;
				}
				console.log();
			})
			.then(err=>console.log(err));
		},
		methods:{
			favIcon:function(event)
			{
				let data = this.$store.getters.formData({
					'image' : event.target.files[0],
					'type'  : 'fav_icon'
				});
				this.http(data, 'fav_icon');
			}, 
			sitLogo:function(event){
				let data = this.$store.getters.formData({
					'image' : event.target.files[0],
					'type'  : 'logo'
				});
				this.http(data, 'logo');
			},
			submit:function(){
				this.http({
					mobile		: this.mobile,
					facebook	: this.facebook,
					title_prefix: this.title_prefix,
					youtube		: this.youtube,
					twitter		: this.twitter,
					linkedin	: this.linkedin,
					mail		: this.mail,
					description	: this.description,
					site_name	: this.site_name,
				}, 'data');
			}, 
			http:function(data, type)
			{
				this.icon = 'fa fa-spinner fa-2x fa-spin';
				axios.post(this.url+'admin/settings', data)
				.then(response=>{
					if(response.data){
						this.response =  Object.assign({}, {[type] : response.data});
						this.icon = 'fa fa-check-square-o fa-2x';
					}
				})
				.then(err=>console.log(err));
			}
		},
		watch:{
			response:function(){
				for(const key in this.response){
					if(key == 'logo'){
						this.logo = this.response.logo;
						this.$message.success('Your Logo Update Successful..');
					}
					else if(key == 'fav_icon'){
						this.fav_icon = this.response.fav_icon;
						this.$message.success('Your Fav Icon Update Successful..');
					}
					else if(key == 'data'){
						this.$message.success('Inoformation Update Successful..');
					}
				}
				console.log(this.fav_icon);
			}
		}

	}
</script>