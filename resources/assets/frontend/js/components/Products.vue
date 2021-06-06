<template>
	<div class="row">
		<div class="product-wrapper" v-for="item in products">
			<a :href="base_url+'product/review/2'">
				<div class="product">
					<div class="image">
						<img :src="base_url+((item.image[0]).medium ? (item.image[0]).medium : (item.image))" alt="">
					</div> 

					<div class="product-info">
						<h5 class="title">{{ title(item.name) }}</h5> 
						<div class="product-price">
							<p class="regular">
								<span>৳ {{ item.present_sale_price }}</span>
							</p> 
							<p class="previous" v-if="+item.total_discount_persentige > 0">
								<span>৳ {{ item.regular_price }} (-{{ item.total_discount_persentige }}%)</span>
							</p>
						</div>
					</div> 
					
					<div class="quick-view-wrapper">
						<div class="quick-view">
							<div class="view-icon">
								<add-to-wishlist
									:product_id="item.id"
								></add-to-wishlist>
								<add-to-cart
									:product="item"
									@view="quickView"
								></add-to-cart>
								<div class="quick-icon" @click="quickView(item.id)">
									<img :src="base_url+'/public/frontend/icon/eye.svg'">
								</div>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<quick-view
			@quickClose="quickClose"
			v-if="quick_view"
			:product_id="qv_produ_id"
		></quick-view>
	</div>
</template>

<script>
	import addToCart 	 from './AddToCart';
	import quickView 	 from './QuickView';
	import addToWishList from './AddToWishList';
	export default {
		name : 'Products',
		components:{
			'add-to-cart' : addToCart,
			'quick-view'  : quickView,
			'add-to-wishlist'  : addToWishList,
		},
		props:{
			products : [Array],
			type 	 : [String]
		},
		data(){
			return {
				base_url:'',
				qv_produ_id : '',
				quick_view  : false,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
		},
		methods:{
			quickView:function(id){
				window.event.preventDefault();
				this.qv_produ_id = id;
				this.quick_view  = true;
			},
			quickClose:function(){
				this.quick_view  = false;
				this.qv_produ_id = '';
			},
			title:function(x){
				if(this.type=='home' && x.length > 55){
					return (x.slice(0, 55))+'...';
				}
				else if(this.type!='home' && x.length > 45){
					return (x.slice(0, 45))+'...';
				}
				return x;
			}
		}
	}
</script>