<template>
	<div class="panel">
		<div class="panel-title"> 
			<h3 class="p-0">Settings</h3> 
		</div>
		<div class="panel-body bp-0">
			<div class="row">
				<div class="col-2">
					<div class="profile-pic">
						<img :src="base_url+ (profile_pic ? profile_pic : 'public/frontend/icon/user.svg')">
						<label class="file">
							<span>Upload New</span>
							<input type="file" @change="image">
						</label>
					</div>
					<div class="fixed-asset">
						<ul>
							<li>shamim.haque</li>
							<li>(+88) {{user_data?user_data.mobile:''}}</li>
						</ul>
					</div>
				</div>
				<div class="col-10">
					<div class="row">
						<div class="form-group col-4">
							<label class="label">Name <span class="text-danger">*</span></label>
							<input type="text" v-model="name" class="form-control" ref="name" :disabled="isDisable">
						</div>
						<div class="form-group col-4">
							<label class="label">Distric</label>
							<select-picker :value.sync="district_id" :watch="districs" cls="custom_slt">
								<div v-for="distric in districs" class="option-field" :data-value="distric.id">{{distric.name}}</div>
							</select-picker>
						</div>
						<div class="form-group col-4">
							<label class="label">Upazila</label>
							<select-picker :value.sync="upazila_id" :watch="upazilas" cls="custom_slt">
								<div class="option-field" v-for="upazila in upazilas" :data-value="upazila.id">{{upazila.name}}</div>
							</select-picker>
						</div>
						<div class="form-group col-2">
							<label class="label">Birthday<span class="text-danger">*</span></label>
							<select-picker :value.sync="b_month" cls="custom_slt" placeholder="Month">
								<div class="option-field" v-for="(key, month) in months" :data-value="month">{{month}}</div>
							</select-picker>
						</div>
						<div class="form-group col-2">
							<label class="label">&nbsp;</label>
							<select-picker :value.sync="b_day" :watch="days" cls="custom_slt" placeholder="Day">
								<div class="option-field" v-for="day in days" :data-value="day">{{(day>9?'':'0')+day}}</div>
							</select-picker>

							<!-- <select v-model="b_day" class="form-control" :disabled="isDisable" required>
								<option value="" disabled>Day</option>
								<option v-for="day in days">{{(day>9?'':'0')+day}}</option>
							</select> -->
						</div>
						<div class="form-group col-2">
							<label class="label">&nbsp;</label>
							<select v-model="b_year" class="form-control" :disabled="isDisable" required>
								<option value="" disabled>Year</option>
								<option v-for="year in years" :value="year">{{year}}</option>
							</select>
						</div>
						<div class="form-group col-2">
							<label class="label">Gender <span class="text-danger">*</span></label>
							<select class="form-control" v-model="gender" :disabled="isDisable">
								<option>-- Gender --</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
								<option value="others">Others</option>
							</select>
						</div>
						<div class="form-group col-4">
							<label class="label">E-Mail</label>
							<input type="text" v-model="email" class="form-control" :disabled="isDisable">
						</div>
						<div class="form-group col-12">
							<label class="label">Address</label>
							<input type="text" v-model="address" class="form-control" :disabled="isDisable">
						</div>
						<div class="form-group col-12 justify-content-end mb-0">
							<button class="btn btn-success" @click="submit">{{button}}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name : 'settings',
		data(){
			return {
				base_url 	: '',
				isDisable	: true,
				button 	 	: 'Edit',
				kernel 		: [],
				months    : {},
				days 	  : [],
				years 	  : [],
				user_data  	: '',
				name 		: '',
				districs	: [],
				district_id : '1',
				upazilas	: [],
				upazila_id 	: '1',
				gender 		: '',
				address 	: '',
				email 		: '',
				b_month		: '',
				b_day 		: '',
				b_year 		: '',
				op_mod      :'2014',
				kkkk 		: [],
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.months   = this.$store.state.months;
			this.setYear();
			this.http('user/profile/get', 'user_data');
			this.http('districs', 'districs');
		},
		methods:{
			setYear:function(){
				let date = new Date();
				let year = date.getFullYear();
				for(var i=1970; i<=year; i++){
					this.years.push(i);
				}
			},
			submit:function(){
				if(this.isDisable==true){
					this.isDisable = false;
					this.$refs.name.focus();
					this.button    = 'Save';
				}
				else{
					this.isDisable = true;
					this.button    = 'Edit';
					this.http('user/profile/update', 'update', {
						name 		: this.name,
						district_id : this.district_id,
						upazila_id 	: this.upazila_id,
						birth_day 	: this.b_year+'-'+this.b_month+'-'+this.b_day,
						gender 		: this.gender,
						email 		: this.email,
						address 	: this.address
					});
				}
			},
			image:function(event){
				if(event.target.files[0]){
					let formData = new FormData();
					formData.append('img', event.target.files[0]);
					this.http('user/profile/update', 'picture', formData);
				}
			},
			http:function(url, type, data=null){
				axios.post(this.base_url+url, data)
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.kernel = Object.assign({}, {[type]: response.data});
					}
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			}
		},
		computed:{
			profile_pic:function(){
				return this.$store.state.user_pic;
			}
		},
		watch:{
			kernel:function(){
				for(let key in this.kernel){
					if(key == 'picture'){
						if(this.kernel[key]!=''){
							this.$store.state.user_pic = this.kernel[key];
							success('✔P rofile Picture Successfully Updated');
						}
					}
					else if(key == 'user_data'){
						this.user_data  = this.kernel[key];
						this.gender 	= this.user_data.gender;
						this.name 		= this.user_data.name;
						this.email 		= this.user_data.email;
						this.address 	= this.user_data.address;
						this.district_id 	= this.user_data.district_id;
						this.upazila_id 	= this.user_data.upazila_id;
						let birthDay 	= this.user_data.birth_day ? (this.user_data.birth_day).split('-') : [];
						this.b_day 		= birthDay[2] ? birthDay[2] : '';
						this.b_month 	= birthDay[1] ? birthDay[1] : '';
						this.b_year 	= birthDay[0] ? birthDay[0] : '';
					}
					else if(key=='update'){
						success("✔ Your Profile Successfully Updated");
						this.$store.state.guard_name = this.kernel[key].name;
					}
					else if(key=='districs'){
						this.districs = this.kernel[key];
					}
					else if(key=='upazilas'){
						this.upazilas = this.kernel[key];
					}
				}
			},
			b_month:function (){
				this.days = [];
				for(let i=1; i<=this.months[this.b_month]; i++){
					this.days.push(i);
				}
			},
			district_id:function(){
				this.http('upazilas', 'upazilas', {district_id:this.district_id});
			}
		}
	}
</script>
<style scoped>
	.custom_slt {
		width: 100%;
	    height: 43px;
	    border-radius: 3px;
	    border: 1px solid #e5e2e2;
	}
</style>