<template>
	<div class="quick-view-fixed">
		<div :class="'quick-view-blade '+class_list">
			<div class="close-btn" @click="close_btn()">&times;</div>
			<div v-if="class_list!='loaded'">
				<span>Loading...</span>
			</div>
			
			<div class="overview-clear" v-else>
				<div class="product-overview">
					<div class="row">
						<div class="col-4">
							<div class="review-image">
								<div class="parent-img">
									<img :src="base_url+image" class="responsive">
								</div>
								<div class="childs-imgs">
									<div class="img-item" v-for="img in available_img">
										<input type="radio" :value="img.large" name="thumbnail" v-model="thumbnail">
										<img :src="base_url+img.smaller" class="responsive">
									</div>
								</div>
								<div class="others" v-if="others_img.length>0">
									<p>Others</p>
									<div class="childs-imgs">
									<div class="img-item" v-for="img in others_img" @click="othersImg(img)">
										<input type="radio" :value="img.large" name="thumbnail" >
										<img :src="base_url+img.smaller" class="responsive">
									</div>
								</div>
								</div>
							</div>
						</div>
						<div class="col-5">
							<div class="product-details">
								<h5>{{product.name}}</h5>
								<div class="short">
									<h4>QUICK OVERVIEW</h4>
									<div class="description">

<pre>
I am shamim,
Also have good experiance
</pre>
									</div>
								</div>
								<div class="quick-action">
									<div class="action-wrapper">
										<div class="price-rating">
											<h4 class="price">
												<span>DBT&nbsp;</span>{{product.present_sale_price}}
												<small class="previous-price"><sub>(<del>৳{{product.regular_price}}</del>)</sub></small>
											</h4>
										</div>
										<div class="rating">
											<span></span>
										</div>
										<small class="rating">Avarage Rating 4/5 - Number of review: 20 <a href="#" class="link">View All</a></small>
										<div class="color-size">
											<table>
												<tr>
													<td>Color&nbsp;</td>
													<td>
														<label v-if="colors.length>0" v-for="color in colors"><input type="radio" :value="color.id" name="color" v-model="color_id">&nbsp;{{ color.name }}</label>
														<label v-if="colors.length==0" >: N/A</label>
													</td>
												</tr>
												<tr>
													<td>Sizes</td>
													<td>
														<div class="size-family" v-if="sizes.length>0">
															<div class="size" v-for="size in sizes">
																<input type="radio" :value="size.id" name="size" v-model="size_id">
																<span>{{ size.name }}</span>
															</div>
														</div>
														<label v-else >: N/A</label>
													</td>
												</tr>
											</table>
										</div>

										<div class="cart-wishlist">
											<add-to-cart
												:product="product"
												:img="image"
												:color_id="color_id"
												:size_id="size_id"
												:color="color"
												:size="size"
												 type='details'
												 @colorSizeImg="colorSizeImg"
											></add-to-cart>

											<div class="add-to-wishlist">
												<button>Add To Wishlist</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="product-infos">
								<div class="info-item">
									<h5>Brand</h5>
									<span>{{product.brand}}</span>
								</div>
								<div class="info-item">
									<h5>Services</h5>
									<span>Free Shipping</span>
								</div>
								<div class="info-item">
									<h5>Services Type</h5>
									<span>Local Seller</span>
								</div>
								<div class="info-item">
									<h5>Warranty Period</h5>
									<span>2 Year</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import addToCart from './AddToCart';
	export default {
		name: 'QuickView',
		components:{
			'add-to-cart' : addToCart,
		},
		props:{
			product_id	: [Number],
		},
		data(){
			return {
				base_url 		: '',
				class_list		: '',
				product 		: '',
				thumbnail 		: '',
				image 			: '',
				size_id 		: '',
				color_id 		: '',
				color 			: '',
				size 			: '',
				not_found 		: 'public/frontend/not_found.svg',
				kernel 			: [],
				colors 			: [],
				sizes 			: [],
				images 			: {},
				available_img 	: {},
				others_img  	: {},
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			let obj = this;
			setTimeout(function(){
				obj.class_list = 'open';
			}, 10);
			this.http('shop/product/quick-view', 'packet', {id: this.product_id});
			this.$store.getters.winScroll('off');
		},
		methods:{
			close_btn:function(){
				this.$store.getters.winScroll('on');
				this.$emit('quickClose');
			},
			http:function(url, type, data=null){
				axios.post(this.base_url+url, data)
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.kernel = Object.assign({}, {[type]: response.data});
					}
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			},
			image_adjust:function(){
				let color 			= this.color_id;
				let size 			= this.size_id;

				(this.colors).filter(x=>(x.id==color ? (this.color=x.name) : ''));
				(this.sizes).filter(x=>(x.id==size ? (this.size=x.name) : ''));

				this.available_img 	= (this.images).filter(x=>(x.color_id==color && (size !=''? x.size_id == size : true) ? x : false));
				this.image 			= (this.available_img.length > 0 ? this.available_img[0].large:this.not_found);
				this.thumbnail 		= (this.available_img.length > 0 ? this.available_img[0].large:this.not_found);

				let available_path = [];
				(this.available_img).filter(x=>(available_path.push(x.large)));	
				this.others_img   	= (this.images).filter(x=>(available_path.indexOf(x.large)) == -1 ? x : false);	
			},
			colorSizeImg:function(nidle){
				this.color_id 	= nidle.color_id;
				this.size_id 	= nidle.size_id;
				this.thumbnail 	= nidle.thumbnail;
			},
			othersImg:function(img){
				this.color_id  = img.color_id;
				this.size_id   = img.size_id;
				this.thumbnail = img.smaller;
			}
		},
		watch:{
			kernel:function(){
				for(let key in this.kernel){
					if(key == 'packet'){
						let packet 			= this.kernel[key];
						this.product 		= packet.product;
						this.colors 		= packet.colors;
						this.sizes 			= packet.sizes;
						this.images 		= packet.images;
						this.available_img 	= packet.images;
						this.image 			= packet.images[0].large;
						this.class_list 	= 'loaded';
						// console.log(this.images);
					}
				}
			},
			thumbnail:function(){
				this.image = this.thumbnail;
			},
			color_id:function(){
				this.image_adjust();
			},
			size_id:function(){
				this.image_adjust();
			}
		}
	}
</script>