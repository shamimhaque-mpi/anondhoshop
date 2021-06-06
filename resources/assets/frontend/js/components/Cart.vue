<template>
	<div class="row mt-3">
		<div class="col-3">
			<div>
				<img :src="base_url+(isCheckout ? checkout_bg : cart_bg)">
			</div>
		</div>

		<div v-if="isCheckout==false" class="col-6">
			<div class="panel cart">
				<div class="panel-head">
					<h2>My Cart</h2>
				</div>
				<div class="panel-body">
					<div v-if="Object.values(items).length>0">
						<div class="item-wrapper">
							<div class="cart-item" v-for="item in items">
								<div class="img">
									<img :src="base_url+item.img">
								</div>
								<div class="item-info">
									<div class="items-detail">
										<h3>{{item.name}}</h3>
										<h4><span>Color: {{item.color?item.color:'N/A'}}</span>, <span>Size: {{item.size?item.size:'N/A'}}</span></h4>
										<div class="info">
											<div class="price">
												<ul>
													<li class="regular">৳ {{item.price}}</li>
													<li v-if="item.price!=item.pre_price"><del>৳ {{item.pre_price}}</del>(-{{item.discount_per}}%)</li>
												</ul>
											</div>
											<div class="set-qty">
												<input type="text" :value="parseFloat(item.qty)" readonly> 
												<span class="nimus" @click="qty_nimus(item)"></span> 
												<span class="plus" @click="qty_plus(item)"></span>
											</div>
										</div>
									</div>
									<div class="action-btn">
										<button class="btn-sml delete" @click="remove(item)">&times;</button>
									</div>
								</div>
							</div>
						</div>
						
						<div class="checkout">
							<div class="grand_total"><strong>Total:</strong> {{parseFloat(grand_total)}} TK</div>
							<button class="btn bg-success float-right" @click="checkout">Checkout Now</button>
						</div>
					</div>
					<div v-else class="nothing_found">
						<span>¯\_(ツ)_/¯</span>
						<span>Nothing Found, <a :href="base_url+'shop'" class="link">< Go To Shop ></a></span>
					</div>
				</div>
			</div>
		</div>

		<checkout 
			:user="user"
			v-if="isCheckout" 
			@back="back"
		></checkout>

		<div v-if="isCheckout==false" class="col-3">
			<div>
				<img v-if="base_url" :src="base_url+'public/frontend/background/bg1.svg'">
			</div>
		</div>
	</div>
</template>

<script>
	import checkout from './Checkout';
	export default {
		name: 'Cart',
		props:['user'],
		components:{
			'checkout' : checkout,
		},
		data(){
			return {
				base_url 	: '',
				isCheckout 	: false,
				grand_total : 0,
				items 		: [],
				cart_bg 	: 'public/frontend/background/bg1.svg',
				checkout_bg : 'public/frontend/background/checkout_bg.svg',
			}
		},
		mounted(){
			this.base_url 	= this.$store.state.base_url;
			this.items 		= this.$store.state.cart;
			this.getGroundTotal();
			this.isCheckout = (this.$store.state.uri=='user/cart/checkout'?true:false);
		},
		methods:{
			checkout:function(){
				let path = this.base_url+'user/cart/checkout';
				if(!this.$store.state.isLogin)
				window.location.href=path;
				else{
					window.history.pushState({path:path}, '', path);
					this.isCheckout = true;
				}
			},
			back:function(){
				this.isCheckout = false;
				let path = this.base_url+'user/cart';
				window.history.pushState({path:path}, '', path);
			},
			qty_plus:function(item){
				this.items[btoa(item.code)].qty = +item.qty+1;
				window.localStorage.cart = JSON.stringify(this.items);
				this.getGroundTotal();
			},
			qty_nimus:function(item){
				if(item.qty > item.min_qty){
					this.items[btoa(item.code)].qty = +item.qty-1;
					this.setCart();
				}
			},
			getGroundTotal:function(){
				let total = 0;
				Object.values(this.items).map(x=>total += (x.qty*parseFloat(x.price)));
				this.grand_total = total.toFixed(2);
			},
			remove:function(item){
				delete this.items[btoa(item.code)];
				this.setCart();
			},
			setCart:function(){
				window.localStorage.cart 	= JSON.stringify(this.items);
				this.$store.state.cartKeys  = Object.keys(this.items);
				this.getGroundTotal();
			}
		}
	}
</script>