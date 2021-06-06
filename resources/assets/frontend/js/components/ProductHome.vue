<template>
	<div>
		<div class="product-panel-head">
			<h5>Popular Products</h5>
		</div>
		<products
			:products="products"
			type="home"
		></products>
	</div>
</template>

<script>
	import products from './Products';
	export default {
		name:'ProductHome',
		components:{
			'products' : products
		},
		data(){
			return {
				base_url 	: '',
				products 	: [],
				loaded 		: false,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.product();
		},
		methods:{
			product:function(start=0, end=18)
			{
				axios.post(this.base_url+'api/product', {start:start, end:end})
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.products = response.data;
						this.loaded   = true;
					}
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			}
		}
	}
</script>