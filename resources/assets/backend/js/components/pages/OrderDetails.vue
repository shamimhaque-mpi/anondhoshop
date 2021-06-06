<template>
	<div class="row space-between">
		<div class="col-8 p-0">
			<div class="table-response">
				<table class="table">
				<caption>All Items</caption>
					<tr>
						<th width="30">SL</th>
						<th>Product Name</th>
						<th>Color</th>
						<th>Size</th>
						<th>Price</th>
						<th>QTY</th>
						<th>Total</th>
						<th width="100" class="text-center">Action</th>
					</tr>
					<tr v-for="(item, key) in items">
						<td>{{++key}}</td>
						<td>{{item.name}}</td>
						<td>{{item.color ? item.color : "N/A"}}</td>
						<td>{{item.size ? item.size : "N/A"}}</td>
						<td>{{item.sale_price}}</td>
						<td>{{item.qty}}</td>
						<td>{{parseFloat(item.sale_price*item.qty).toFixed(2)}}</td>
						<td class="p-0">
							<select class="status" :value="item.status" @change="changeStatus($event.target.value, item.id)">
								<option value="pending">Pending</option>
								<option value="processing">Processing</option>
								<option value="ready">Ready</option>
								<option value="shipped">Shipped</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="5" class="text-right"><strong>Total</strong></td>
						<td>{{parseFloat(total_qty).toFixed(2)}}</td>
						<td>{{parseFloat(total_amount).toFixed(2)}}</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-3 p-0">
			<table class="table payment-details">
				<caption class="text-left">Payment Details</caption>
				<tr>
					<td>Payment Method</td>
					<td class="text-right">Cash On Delivery</td>
				</tr>
				<tr>
					<td>Paid Amount</td>
					<td class="text-right">500TK</td>
				</tr>
				<tr>
					<td>Transaction Status</td>
					<td class="text-right">Pending (Authority)</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td class="text-right">{{order.grand_total}}TK</td>
				</tr>
				<tr>
					<td>Shipping Charge</td>
					<td class="text-right">{{order.shipping_charge}}TK</td>
				</tr>
				<tr>
					<td>Coupon Discount</td>
					<td class="text-right">{{order.coupon_discount}}TK</td>
				</tr>
				<tr>
					<th class="text-right">Total :</th>
					<td class="text-right">{{order.grand_total}}TK</td>
				</tr>
			</table>

			<br>

			<table class="table payment-details">
				<caption class="text-left">User Details</caption>
				<tr>
					<td>Name</td>
					<td class="text-right">{{order.name}}</td>
				</tr>
				<tr>
					<td>Mobile</td>
					<td class="text-right">{{order.mobile}}</td>
				</tr>
				<tr>
					<td>Address</td>
					<td class="text-right">{{order.address}}</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
	export default {
		name : 'OrderDetails',
		props:['order_id'],
		data(){
			return {
				base_url 	 : '',
				order  		 : {},
				items  		 : {},
				kernel 		 : {},
				total_qty  	 : 0,
				total_amount : 0,
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			this.http('admin/order/details', 'order', {order_id:this.order_id});
		},
		methods:{
			http:function(url, type, data=null){
				axios.post(this.base_url+url, data)
				.then(response=>{
					this.kernel = Object.assign({}, {[type]:response.data});
				})
				.then(err=>console.log(err));
			},
			changeStatus:function(status, item_id){
				let data = {
					status  : status,
					item_id : item_id,
					order_id: this.order_id,
				}
				this.http('admin/order/status', 'status', data);
			}
		},
		watch:{
			kernel:function(){
				for(const key in this.kernel){
					//get order
					if(key=="order"){
						let data = this.kernel[key];
						if(data.order_info)
							this.order = data.order_info;
						if(data.items){
							this.items = data.items;
							for(const key in this.items){
								this.total_qty += +this.items[key].qty;
								this.total_amount += +(this.items[key].sale_price*this.items[key].qty);
							}
						}
					}
					if(key=="status"){
						console.log(this.kernel[key]);
					}
				}
			}
		}
	}
</script>

<style scoped>
	.status{
		width: 100px;
	    padding: 5px;
	    border: 1px solid #ddd;
	    outline: none;
	}
</style>