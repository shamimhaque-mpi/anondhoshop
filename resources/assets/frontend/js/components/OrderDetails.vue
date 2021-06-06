<template>
	<div class="row space-between">
		<div class="col-7 p-0">
			<div class="cart-item-wrapper">
				<div class="cart-item" v-for="item in items">
					<div class="img">
						<img :src="base_url+item.img">
					</div>
					<div class="cart-item-info">
						<div class="items-detail">
							<h3>{{item.title}}</h3>
							<h4><span>Color: {{item.color ? item.color : 'N/A'}}</span>, <span>Size: {{item.size ? item.size : 'N/A'}}</span></h4>
							<h4><span class="qty-p-d">Quantity: {{item.qty}} {{item.unit ? item.unit : ''}}</span></h4>
							<div class="info info-p-d">
								<div class="price">
									<ul>
										<li class="regular">৳ {{item.sale_price}}</li>
									</ul>
								</div><span class="grand-total">Total: {{toFloat(item.qty)}}x{{toFloat(item.sale_price)}}={{toFloat(item.qty*item.sale_price).toFixed(2)}}TK</span>
							</div>
						</div>
						<div class="action-btn d-page">
							<button class="btn-sml delete">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4 p-0 details">
			<table class="table payment-details">
				<caption class="text-left">Order Details</caption>
				<tr>
					<td>Date</td>
					<td class="text-right">{{date}}</td>
				</tr>
				<tr>
					<td>Payment Method</td>
					<td class="text-right">Cash On Delivery</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td class="text-right">{{grand_total}}TK</td>
				</tr>
				<tr>
					<td>Shipping Charge</td>
					<td class="text-right">{{shipping_charge}}TK</td>
				</tr>
				<tr>
					<td>Coupon Discount</td>
					<td class="text-right">{{coupon_discount}}TK</td>
				</tr>
				<tr>
					<th>Total :</th>
					<td class="text-right">{{grand_total}}TK</td>
				</tr>
			</table>

			<br>

			<table class="table payment-details">
				<caption class="text-left">Shipping Details</caption>
				<tr>
					<td>Name</td>
					<td class="text-right">{{user_name}}</td>
				</tr>
				<tr>
					<td>Mobile</td>
					<td class="text-right">{{mobile}}</td>
				</tr>
				<tr>
					<td>Address</td>
					<td class="text-right">{{address}}</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script >
	export default {
		name:'OrderDetails',
		props:['order_id'],
		data(){
			return {
				base_url 	: '',
				user_name 	: '',
				items 		: [],
				address 	: '',
				mobile 		: 0,
				grand_total : 0,
				total 		: 0,
				coupon_discount : 0,
				shipping_charge : '',
				date 			: '',
			}
		},
		mounted(){
			this.base_url 	= this.$store.state.base_url;
			this.user_name  = this.$store.state.guard_name;
			this.http('user/get/order/'+this.order_id);
		},
		methods:{
			http:function(url, data=null){
				axios.post(this.base_url+url)
				.then(response=>{
					console.log(response.data);
					if(response.data && response.data != 0)
						this.items = response.data;
				})
				.then(err=>(err?console.log(err):''));
			},
			toFloat:function(num){
				return parseFloat(num);
			}
		},
		watch:{
			items:function(){
				if(this.items){
					this.mobile	= this.items[0].mobile;
					this.total	= this.items[0].total;
					this.date   = this.items[0].created_at;
					this.address			= this.items[0].address;
					this.grand_total		= this.items[0].grand_total;
					this.shipping_charge	= this.items[0].shipping_charge;
					this.coupon_discount	= this.items[0].coupon_discount ? this.items[0].coupon_discount : 0;
				}
			}
		}
	}
</script>
<style scoped>

</style>