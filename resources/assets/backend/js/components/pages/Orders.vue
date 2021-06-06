<template>
<div>
	<div class="row" v-if="!isDetails">
		<div class="col-2">
			<select class="form-control">
				<option value="">All Orders</option>
				<option value="pending">Pending Orders</option>
				<option value="complete">complete Orders</option>
			</select>
		</div>
		<div class="col-2">
			<input type="text" class="form-control" placeholder="Mobile No">
		</div>
		<div class="col-2">
			<input type="text" class="form-control" placeholder="Username">
		</div>
		<div class="col-2">
			<input type="date" class="form-control">
		</div>
		<div class="col-2">
			<input type="date" class="form-control">
		</div>
		<div class="col-1">
			<input type="button" class="btn btn-success" value="Search">
		</div>
	</div>

	<div class="orders mt-2" v-if="!isDetails">
		<div class="row">
			<div class="col-12">
				<div class="table-responsive">
					<table class="table">
						<caption>Pending: 6,&nbsp;&nbsp;complete: 9</caption>
						<tr>
							<th width="30">SL</th>
							<th>Date</th>
							<th>Code</th>
							<th>User Name</th>
							<th>Mobile</th>
							<th>Address</th>
							<th>Items</th>
							<th>Status</th>
							<th width="120" class="text-center">Action</th>
						</tr>
						<tr v-for="(item, key) in items">
							<td>{{++key}}</td>
							<td>{{item.created_at}}</td>
							<td>{{idToVoucher(item.id)}}</td>
							<td>{{item.name}}</td>
							<td>{{item.mobile}}</td>
							<td>{{item.address}}</td>
							<td>{{item.total_item}}</td>
							<td>{{item.status}}</td>
							<td>
								<div class="btn-group m-auto">
									<a @click="view(item.id)" href="" class="btn-sml btn-success"><i class="fa fa-eye"></i></a>
									<a class="btn-sml bg-warning"><i class="fa fa-trash"></i></a>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<order-details 
		v-if="isDetails"
		:order_id="order_id"
	></order-details>
</div>
</template>

<script>
	import orderDetails from './OrderDetails';
	export default {
		name:'Orders',
		components:{
			'order-details':orderDetails,
		},
		data(){
			return {
				base_url 	:'',
				kernel  	:{},
				items 		:{},
				isDetails 	: false,
				order_id 	: null,
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			this.http('admin/order/all', 'orders');
		},
		methods:{
			http:function(url, type, data=null){
				axios.post(this.base_url+url, data)
				.then(response=>{
					this.kernel = Object.assign({}, {[type]:response.data});
				})
				.then(err=>console.log(err));
			},
			view:function(id){
				window.event.preventDefault();
				this.isDetails = true;
				this.order_id = id;
			},
			idToVoucher:function(num){
				let len = (num.toString()).length;
				if(len==1){
					return '000'+num;
				}
				if(len==2){
					return '00'+num;
				}
				if(len==3){
					return '0'+num;
				}
				else
					return num;
			}
		},
		watch:{
			kernel:function(){
				for(const key in this.kernel){
					if(key=='orders'){
						this.items = this.kernel[key];
					}
				}
			}
		}
	}
</script>