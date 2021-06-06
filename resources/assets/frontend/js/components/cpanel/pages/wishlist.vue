<template>
	<div class="panel">
		<div class="panel-title"> 
			<h3 class="p-0">Wish-List</h3> 
		</div>
		<div class="panel-body">
			<div class="row">

				<div class="product-wrapper" v-for="item in products">
					<a href="#" @click="deleteWishList(item.id)">
						<div class="product">
							<div class="close">&times;</div>
							<div class="product-img">
								<img :src="base_url+item.img">
							</div>
							<div class="product-info">
								<h5>{{title(item.name)}}</h5>
								<div class="product-price">
									<strong>৳{{Math.round(item.price)}}</strong>
									<span v-if="(item.discount > 0)"><del>৳{{Math.round(item.regular_price)}}</del>(-{{Math.round(item.discount)}}%)</span>
								</div>
							</div>
							<div class="view">Add To Cart</div>
						</div>
					</a>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name : 'wishlist',
		data(){
			return {
				base_url : '',
				products : '',
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.getWishList();
		},
		methods:{
			getWishList:function(){
				this.http('user/ajax/wishlist');
			},
			deleteWishList:function(id){
				window.event.preventDefault();
				this.http('user/ajax/delete-wishlist', {product_id:id});
				this.$store.getters.removeProduct(id);
			},
			http:function(url, data=null){
				axios.post(this.base_url+url, data)
				.then(response=>{
					this.products = (response.data);
				})
				.then(err=>console.log(err));
			},
			title:function(x){
				if(x.length > 55){
					return (x.slice(0, 55))+'...';
				}
				return x;
			}
		}
	}
</script>