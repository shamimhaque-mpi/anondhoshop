<template>
	<div class="h100">
		<div class="add-to-cart" v-if="type=='details' && !plus_one">
			<button @click="addToCart">Add To Cart</button>
		</div>

		<div class="set-qty" v-if="type=='details' && plus_one">
			<input type="text"  :value="parseFloat(qty)" readonly>
			<span :class="'nimus '+nimus_class" @click="qty_nimus(product)"></span>
			<span class="plus"  @click="qty_plus(product)"></span>
		</div>

		<div @click="addToCart" class="quick-icon" v-if="type!='details'" :title="title">
			<img :src="base_url+(plus_one ? plus_one : cart_icon)">
		</div>
	</div>
</template>

<script>
	export default {
		name: 'AddToCart',
		props:{
			product		: [Object],
			color_id 	: [String, Number],
			size_id 	: [String, Number],
			color		: [String],
			size		: [String],
			type		: [String],
			img 		: [String],
		},
		data(){
			return {
				base_url 	: '',
				cart_icon 	: 'public/frontend/icon/cart-plus.svg',
				isCartAdd 	: true,
				isAvailable : false,
				nimus_class : '',
				title 	 	: 'Add To Cart',
				items 	 	: [],
				qty 	 	: 0,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			this.items 	  = this.$store.state.cart;
			this.isColorOrSize();
			this.cartSetUp();
		},
		methods:{
			addToCart:function(event){
				event.preventDefault();
				this.checkColorOrSize();
				if(this.isCartAdd || this.isAvailable)
				{
					let product = this.product;
					let keys 	= this.$store.state.cartKeys;
					this.items 	= this.$store.state.cart;

					if(keys.indexOf(btoa(product.id))>-1){
						let qty = this.items[btoa(product.id)].qty;
						this.items[btoa(product.id)].qty = +qty+1;
					}
					else{
						Object.assign(this.items ,{
							// Rows Wise Items Add To Cart	
							[btoa(product.id)] : {
								code		: product.id,
								name		: product.name,
								qty 		: product.min_sale_quantity,
								price 		: product.present_sale_price,
								min_qty 	: product.min_sale_quantity,
								pre_price 	: product.regular_price,
								discount_per: product.total_discount_persentige,
								color_id 	: this.color_id,
								size_id     : this.size_id,
								color 		: this.color,
								size 		: this.size,
								img			: product.image,
							}
						});
						if(this.type && this.type=='details')
						this.setImgColorSize(true);
					}
					this.CheckCart();
				}
				else{this.$emit('view', this.product.id)}

			},
			isColorOrSize:function(){
				let color = this.product.color_name;
				let size  = this.product.size_name;
				if(color || size){
					this.isCartAdd 	= false;
					this.title 		= 'View Details Of This Product';
					this.cart_icon  = 'public/frontend/icon/details.svg';
				}
			},
			checkColorOrSize:function(){
				let color = this.product.color_name;
				let size  = this.product.size_name;
				if(this.type=='details' && (color || size)){
					this.isCartAdd 	= false;
					if(color && !this.color_id){
						warning("Please Choice a Color");
					}
					else if(size && !this.size_id){
						warning("Please Choice a Size");
					}
					else if(this.img=='public/frontend/not_found.svg'){
						warning("Something Wrong!, Please Try Again...");
					}
					else{
						this.isCartAdd = true;
						return true;
					}
					return false;
				}
				return true;
			},
			cartSetUp:function(){
				let cart = window.localStorage.cart;
				if(cart){
					cart = JSON.parse(cart)
					this.$store.state.cart 		= cart;
					this.$store.state.cartKeys  = Object.keys(cart);
					if(this.isAvailable){
						let product = this.product;
						this.$emit('colorSizeImg', {
							color_id 	: cart[btoa(product.id)].color_id,
							size_id 	: cart[btoa(product.id)].size_id,
							thumbnail 	: cart[btoa(product.id)].img,
						});
					}
				}
			},
			qty_plus:function(item) {
				this.items[btoa(item.id)].qty = +this.items[btoa(item.id)].qty+1;
				this.CheckCart();

			},
			qty_nimus:function(item){
				if(this.items[btoa(item.id)].qty > item.min_sale_quantity){
					this.items[btoa(item.id)].qty = +this.items[btoa(item.id)].qty-1;
					this.CheckCart();
				}
			},
			CheckCart:function(){
				var data = {};
				if(Object.keys(this.items).length>0){
					data = this.items;
				}
				window.localStorage.cart 	= JSON.stringify(data);
				this.$store.state.cart 		= data;
				this.$store.state.cartKeys 	= Object.keys(data);
			},
			setImgColorSize:function(nidle=false){
				if(this.checkColorOrSize() && (this.isAvailable || nidle)){
					var item = this.product;
					if(this.img!=''){
						this.items[btoa(item.id)].img 	   = this.img;
					}
					if(this.color_id!=''){
						this.items[btoa(item.id)].color_id 	= this.color_id;
						this.items[btoa(item.id)].color 	= this.color;
					}
					if(this.size_id!=''){
						this.items[btoa(item.id)].size_id  	= this.size_id;
						this.items[btoa(item.id)].size  	= this.size;
					}
					this.CheckCart();
				}
			}
		},
		watch:{
			img:function(){
				this.setImgColorSize();
			},
			color_id:function(){
				this.setImgColorSize();
			},
			size_id:function(){
				this.setImgColorSize();
			}
		},
		computed:{
			plus_one:function(){
				if((this.$store.state.cartKeys).indexOf(btoa(this.product.id))>-1){
					this.qty 		 = this.$store.state.cart[btoa(this.product.id)].qty;
					this.min_qty	 = this.$store.state.cart[btoa(this.product.id)].min_qty;
					this.title 		 = "Quantity + 1 In Your Cart";
					this.isAvailable = true;

					if(this.qty == this.min_qty)
					this.nimus_class = 'cursor_disable';
					else
					this.nimus_class = '';
					return "public/frontend/icon/plus_one.svg";
				}
				return false;
			}
		}
	}
</script>