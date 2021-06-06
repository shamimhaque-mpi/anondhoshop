<template>
	<div class="col-9">
		<div class="panel cart">
			<div class="panel-head">
				<h2>{{order_id ? 'Order Details':'Shipping Details'}}</h2>
				<button class="float-right btn-sml bg-default" @click="back">Back</button>
			</div>
			<div class="panel-body">
				<div class="row space-between" v-if="!order_id">
					<div class="col-7 pl-0">
						<div class="card shipping">
							<div class="row">
								<div class="col-6">
									<label class="label-control">Coupon No</label>
									<input type="text" class="form-control" placeholder="Enter Your Coupon code">
								</div>

								<div class="col-6">
									<label class="label-control">Alternative Phone No</label>
									<input type="text" v-model="alt_mobile" class="form-control">
								</div>
								
								<div class="col-6">
									<label class="label-control">District</label>
									<input type="text" v-model="district_id" class="form-control">
								</div>

								<div class="col-6">
									<label class="label-control">Upazila</label>
									<input type="text" v-model="upazila_id" class="form-control">
								</div>

								<div class="col-12">
									<label class="label-control">Address</label>
									<textarea rows="4" v-model="address" class="form-control" placeholder="Address"> </textarea>
								</div>

								<div class="col-6">
									<label class="label-control">Payment Method</label>
									<select v-model="payment_method" class="form-control">
										<option value="">--Select A Method--</option>
										<option value="">bkash</option>
										<option value="">Datch Bangla</option>
										<option value="">SureCash</option>
										<option value="">Cash On Delivery</option>
									</select>
								</div>
								<div class="col-6">
									<label class="label-control">&nbsp;</label>
									<input type="text" class="form-control" readonly>
								</div>

								<div class="col-12">
									<button @click="submit" class="btn bg-success float-right">Submit</button>
								</div>
							</div>
						</div>
					</div>

					<div class="col-4 details">
						<table class="table payment-details">
							<caption class="text-left">Payment Details</caption>
							<tr>
								<td>Grand Total</td>
								<td class="text-right">{{grand_total}}TK</td>
							</tr>
							<tr>
								<td>Shipping Cost</td>
								<td class="text-right">{{shipping_cost}}TK</td>
							</tr>
							<tr>
								<td>Coupon Discount</td>
								<td class="text-right">{{coupon_discount}}TK</td>
							</tr>
							<tr>
								<th class="text-right">Total :</th>
								<td class="text-right">{{total}}TK</td>
							</tr>
						</table>

						<br>

						<table class="table payment-details">
							<caption class="text-left">User Details</caption>
							<tr>
								<td>Name</td>
								<td class="text-right">{{name}}</td>
							</tr>
							<tr>
								<td>Mobile</td>
								<td class="text-right">{{mobile}}</td>
							</tr>
							<tr>
								<td>E-mail</td>
								<td class="text-right">{{email}}</td>
							</tr>
						</table>
					</div>

				</div>
				<order-details
					v-if="order_id"
					:order_id="order_id"
				>
				</order-details>
			</div>
		</div>
	</div>
</template>
<script>
	import Order_details from './OrderDetails';
	export default {
		name : 'Checkout',
		components:{
			'order-details' : Order_details,
		},
		props:['user'],
		data() {
			return {
				base_url 		: '',
				name 			: '',
				mobile 			: '',
				email 			: '',
				address 		: '',
				district_id 	: '',
				upazila_id 		: '',
				alt_mobile 		: '',
				payment_method	: '',
				grand_total 	: 0,
				shipping_cost 	: 0,
				coupon_discount : 0,
				total 			: 0,
				cart 			: '',
				order_id 		: '',
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.cart = this.$store.state.cart;
			this.devide();
			this.getCart();
		},
		methods:{
			back:function(){
				this.$emit('back');
			},
			devide:function(){
				if(this.user){
					let user  		 = JSON.parse(this.user);
					this.name 		 = user.name;
					this.mobile 	 = user.mobile;
					this.district_id = user.district_id;
					this.upazila_id  = user.upazila_id;
					this.alt_mobile  = user.mobile;
					this.email 		 = user.email;
					this.address 	 = user.address;
				}
			},
			getCart:function(){
				if((this.$store.state.cartKeys).length>0){
					let cart = this.cart;
					let total_amount = 0;
					for(let key in cart){
						total_amount += (cart[key].price*cart[key].qty);
					}
					this.grand_total = total_amount;
					this.getVoucher();
				}
				else
					window.location.href=this.base_url+'shop';
			},
			getVoucher:function(){
				this.total = (this.grand_total+this.shipping_cost)-this.coupon_discount;
			},
			submit:function(){
				if(this.validation()){
					let data = {
						address 	: this.address,
						district_id : this.district_id,
						upazila_id 	: this.upazila_id,
						alt_mobile 	: this.alt_mobile,
						cart 		: Object.values(this.cart),
					}
					axios.post(this.base_url+'user/cart/submit', data)
					.then(reponse=>{
						if(reponse.data){
							this.order_id = (reponse.data).id;
							window.localStorage.clear();
							this.$store.state.cartKeys	='';
							success('🔷 Thank Your For Purchase...');
						}
					})
					.then(err=>console.log(err));
				}
			},
			validation:function()
			{	
				let isEmpty = false;
				if(!isEmpty && !this.address){
					isEmpty=true;
					warning('❌Please Enter Your Shipping Address!!');
				}
				else if(!isEmpty && !this.alt_mobile){
					isEmpty=true;
					warning('❌Please Enter Your Phone Number!!');
				}
				else if(!isEmpty && !this.district_id){
					isEmpty=true;
					warning('❌Please Select A District!!');
				}
				else if(!isEmpty && !this.upazila_id){
					isEmpty=true;
					warning('❌Please Select A Upazila!!');
				}
				return !isEmpty;
			}
		}
	}
</script>