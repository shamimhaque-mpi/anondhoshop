<template>
	<div class="position-relative">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>SL</th>
					<th>Date</th>
					<th>Title</th>
					<th>Purchase Price</th>
					<th>Sale Price</th>
					<th>Min-Sale Qty</th>
					<th>Unit</th>
					<th>Action</th>
				</tr>
				<tr v-for="(value, key) in products">
					<td>{{ key+1 }}</td>
					<td width="110">{{ (value.created_at).slice(0, 10) }}</td>
					<td>{{ value.name }}</td>
					<td>{{ value.purchase_price }}</td>
					<td>{{ value.regular_price }}</td>
					<td>{{ value.min_sale_quantity }}</td>
					<td>{{ (value.unit ? value.unit.name : '') }}</td>
					<td width="10">
						<div class="btn-group">
							<a :href="base_url+'admin/product/view/'+value.id" class="btn btn-sml bg-info"><i class="fa fa-eye"></i></a>
							<a :href="base_url+'admin/product/edit/'+value.id" class="btn btn-sml bg-success"><i class="fa fa-pencil-square-o"></i></a>
							<a @click="trash(value.id)" class="btn btn-sml bg-danger"><i class="fa fa-trash"></i></a>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="caption" v-if="loader">
			<h4 v-if="loader=='nothing'"> There Is Nothing </h4>
			<h4 v-else><span><i class="fa fa-spinner fa-spin"></i></span> Loading....</h4>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'ProductList',
		data(){
			return {
				kernel	: {},
				base_url: '',
				products: [],
				loader  : '',
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			this.loader='loading';
			this.http('admin/product/all', 'product');
		},
		methods:{
			trash:function(id){
				this.loader='loading';
				this.http('admin/product/trash', 'product', {id:id});
			},
			http:function(url, type, data=null)
			{
				axios.post(this.base_url+url, data)
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.kernel = Object.assign({}, {[type]: response.data});
					}
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			}
		},
		watch:{
			kernel:function(){
				for(const key in this.kernel){
					if(key == 'product'){
						this.products = this.kernel[key];
						this.loader   = (this.products.length <=0 ? 'nothing':'');
					}
				}
			},
		},
	}
</script>