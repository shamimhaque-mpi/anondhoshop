<template>
	<div class="panel">
		<div class="panel-title"> 
			<h3 class="p-0">My Order</h3> 
		</div>
		<div class="panel-body">
			<div class="row space-between" v-if="!isDetails">
				<div class="col-8 p-0">
					<input type="date" v-model="date" class="form-control col-3 mb-1">
					<div class="table-reponsive">
						<table class="table">
							<tr>
								<th>SL</th>
								<th>Date</th>
								<th>Amount</th>
								<th>Items</th>
								<th>Mobile No</th>
								<th>Status</th>
								<th width="100">Action</th>
							</tr>
							<tr v-for="(item, key) in items">
								<td>{{++key}}</td>
								<td>{{item.created_at}}</td>
								<td>{{item.grand_total}} TK</td>
								<td>{{item.total_item}}</td>
								<td>{{item.mobile}}</td>
								<td>{{item.status}}</td>
								<td>
									<div class="btn-group">
										<button 
											class="btn-sml btn-success"
											@click="viewDetails(item.id)"
										>view Details</button>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div> 
				<div class="col-3 pl-3 user-panel-details">
					<table class="table payment-details">
						<caption class="text-left">Short Reports</caption>
						<tr>
							<td>Payment</td>
							<td class="text-right">500TK</td>
						</tr>
						<tr>
							<td>Complete Order</td>
							<td class="text-right">10</td>
						</tr>
						<tr>
							<td>Pending Order</td>
							<td class="text-right">10</td>
						</tr>
						<tr>
							<td>Return</td>
							<td class="text-right">0</td>
						</tr>
						<tr>
							<td>Wish-List</td>
							<td class="text-right">0</td>
						</tr>
					</table>
				</div>
			</div>
			<order-details 
				v-if="isDetails"
				:order_id="order_id"
			></order-details>
		</div>
	</div>
</template>

<script>
	export default {
		name : 'my_order',
		data(){
			return {
				items 		: {},
				base_url 	: '',
				kernel 		: {},
				date 		: '',
				order_id	: '',
				isDetails 	: false,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.http('user/all/order', 'products');
		},
		methods:{
			http:function(url, type, data=null){
				axios.post(this.base_url+url, data)
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.kernel = Object.assign({}, {[type]: response.data});
					}
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			},
			viewDetails:function(order_id){
				this.order_id = order_id;
				this.isDetails = true;
			}
		},
		watch:{
			kernel:function(){
				for(let key in this.kernel){
					if(key == 'products'){
						this.items = this.kernel[key];	
					}
				}
			},
			date:function(){
				console.log(this.date);
			}
		}
	}
</script>