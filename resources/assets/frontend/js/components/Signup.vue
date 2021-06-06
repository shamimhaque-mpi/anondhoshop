<template>
	<form @submit="submit">
	<div class="form">
		<div class="icon p-0">
			<img :src="base_url+'public/frontend/icon/regi-1.webp'">
		</div>
		<div class="form-group">
			<label>Full Name</label>
			<input type="text" v-model="name" class="form-control" placeholder="Please Enter Your Full Name" required>
		</div>
		<div class="form-group">
			<label>Mobile Number</label>
			<input type="text" v-model="mobile" inputmode="numeric" pattern="[0-9]*" class="form-control" placeholder="Please Enter Your Mobile No" required>
		</div>
		<div class="birthday_gender">
			<div class="form-group">
				<label>Birthday</label>
				<div class="birth-date">
					<select v-model="b_month" required>
						<option value="" disabled>Month</option>
						<option v-for="(key, month) in months" :value="month">{{month}}</option>
					</select>
					<select v-model="b_day" required>
						<option value="" disabled>Day</option>
						<option v-for="day in days">{{(day>9?'':'0')+day}}</option>
					</select>
					<select v-model="b_year" required>
						<option value="" disabled>Year</option>
						<option v-for="year in years" :value="year">{{year}}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label>Gender</label>
				<select v-model="b_gender" required>
					<option value="" disabled>Select</option>
					<option value="male">Male</option>
					<option value="femile">Femile</option>
					<option value="others">Others</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label>Password</label>
			<input type="password" v-model="password" class="form-control" placeholder="Please Enter A New Password" required>
		</div>
		<div class="form-action">
			<label><input type="checkbox" v-model="is_terms" checked="true" value="1">&nbsp;I agree to  {{site_name}} <a href="#">Terms </a> and <a href="#">Privacy Policy</a></label>
			<button>SIGN UP</button>
		</div>
	</div>
	</form>
</template>

<script>
	export default {
		name: 'Signup',
		props: {
			site_name:[String],
		},
		data(){
			return {
				base_url : '',
				months    : {},
				days 	  : [],
				years 	  : [],
				b_month	  : '',
				b_day 	  : '',
				b_year 	  : '',
				b_gender  : '',
				is_terms  : true,
				name 	  : '',
				mobile 	  : '',
				password  : '',
				acc_exist : false,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.months = this.$store.state.months;
			this.setYear();
		},
		methods:{
			setYear:function(){
				let date = new Date();
				let year = date.getFullYear();
				for(var i=1970; i<=year; i++){
					this.years.push(i);
				}
			},
			submit:function(event){
				event.preventDefault();
				var b_month 	= this.b_month;
				var b_day 		= this.b_day
				var b_year 		= this.b_year;
				var b_gender 	= this.b_gender;
				var is_terms 	= this.is_terms;
				var name 		= this.name;
				var mobile 		= this.mobile;
				var password 	= this.password;
				if(b_month && b_day && b_year && b_gender && name && mobile && password){
					if(mobile.length==11)
					{
						var data = {
							gender 	  : b_gender,
							birth_day : (b_year+'-'+b_month+'-'+b_day),
							name  	  : name,
							mobile 	  : mobile,
							password  : password,
							is_terms  : (is_terms ? 1:0)
						};
						this.request(data);
					}else{
						warning("Please Enter A Valid Number ⁉");						
					}
				}else{
					warning("Something Wrong ⁉");
				}
			},
			request:function(data){
				axios.post(this.base_url+'sign-up', data)
				.then(response=>{
					if(!response.data){
						this.acc_exist = true;
						this.password  = '';
						warning('❌ An Account Already Exist ‼');
					}
					else{
						this.$emit('userPermit', this.mobile);
						success("✔ You've successfully registered");
					};
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			}
		},
		watch:{
			b_month:function (){
				this.days = [];
				for(let i=1; i<=this.months[this.b_month]; i++){
					this.days.push(i);
				}
			}
		}
	}
</script>