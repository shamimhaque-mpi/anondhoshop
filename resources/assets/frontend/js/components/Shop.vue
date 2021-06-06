<template>
	<div class="shop">
		<div class="row mb-1">
			<div class="col-12 filter-header">
				<span class="filler-mobile" @click="filterBtn">Filter</span>
				<div class="filler-title">
					<span v-if="search_by">{{ search_by.key_name }} > {{ search_by.key }}</span>
					<span v-else >You Can Search With Category Or Sub Category...</span>
				</div>
				<div class="sort">
					<span>Sort By</span> &nbsp; &nbsp;
					<select id="sortby" v-model="sort_amount">
						<option value="">-- Select Sort Field --</option>
						<option value="ASC">Price Low To Hight</option>
						<option value="DESC">Price Hight To Low</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row" style="background: #fff;">
			<div :class="forMobile" class="filter">
				<div class="filter-box">
					<div class="close" @click="filterBtn">&times;</div>

					<div class="section" v-if="brands.length>0">
						<h5>Brands</h5>
						<ul>
							<li v-for="brand in brands"><label><input type="checkbox" v-model="brandM" :value="brand.id">&nbsp;{{ brand.name }}</label></li>
							<li v-if="(brands.length)==5"><label class="view-more">View More</label></li>
						</ul>
					</div>

					<div class="section">
						<h5>Price Range</h5>
						<div class="price-range">
							<input type="text" v-model="min" placeholder="MIN" autocomplete="off">
							<span>-</span>
							<input type="text" v-model="max" placeholder="MAX" autocomplete="off">
							<input type="button" value="SET" @click="amountRang">
						</div>
					</div>

					<div class="section" v-if="colors.length>0">
						<h5>Color Family</h5>
						<ul>
							<li v-for="color in colors"><label><input type="checkbox" v-model="colorM" :value="color.id">&nbsp;{{ color.name }}</label></li>
							<li v-if="(colors.length)==5"><label class="view-more">View More</label></li>
						</ul>
					</div>

					<div class="section" v-if="sizes.length>0">
						<h5>Size Family</h5>
						<ul>
							<li v-for="size in sizes"><label><input type="checkbox" v-model="sizeM" :value="size.id">&nbsp;{{ size.name }}</label></li>
							<li v-if="(sizes.length)==5"><label class="view-more">View More</label></li>
						</ul>
					</div>

					<div class="section" v-if="units.length>0">
						<h5>Units</h5>
						<ul>
							<li v-for="unit in units"><label><input type="checkbox" v-model="unitM" :value="unit.id">&nbsp;{{ unit.name }}</label></li>
							<li v-if="(units.length)==5"><label class="view-more">View More</label></li>
						</ul>
					</div>

					<div class="section">
						<h5>Services</h5>
						<ul>
							<li><label><input type="checkbox">&nbsp;Cash On Delivery</label></li>
							<li><label><input type="checkbox">&nbsp;Free Shipping</label></li>
							<li><label class="view-more">View More</label></li>
						</ul>
					</div>

					<div class="section">
						<h5>Warranty Type</h5>
						<ul>
							<li><label><input type="checkbox">&nbsp;No Warranty</label></li>
							<li><label><input type="checkbox">&nbsp;Local Seller Warranty</label></li>
							<li><label><input type="checkbox">&nbsp;Internation Manufacturer</label></li>
							<li><label class="view-more">View More</label></li>
						</ul>
					</div>

					<div class="section">
						<h5>Warranty Period</h5>
						<ul>
							<li><label><input type="checkbox">&nbsp;2 Year</label></li>
							<li><label class="view-more">View More</label></li>
						</ul>
					</div>

				</div>
			</div>
			<div class="product-box-wrapper">

				<products 
					v-if="products && forceload" 
					:products="products"
				></products>
				
				<pagination
					total="320"
					per_page="20"
					last_index='100'
				></pagination>
				
				<div class="not-found" v-if="loading_text">
					<h3>{{loading_text}}</h3>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import products		from './Products';
	import pagination   from './Pagination';
	export default {
		name 		: 'Shop',
		components	: {
			'products'   : products,
			'pagination' : pagination,
		},
		props : {
			slug:[String],
			ids :[Object]
		},
		data(){
			return {
				base_url 	: '',
				kernel 	 	: {},
				forMobile	: '',
				brands 		: [],
				colors 		: [],
				sizes 		: [],
				units 		: [],
				products	: [],

				search_by 	: '',
				sort_amount : '',

				colorM 		: [],
				sizeM 		: [],
				brandM 		: [],
				unitM 		: [],
				min 		: '',
				max 		: '',
				ref_cat		: '',
				ref_s_cat	: '',
				ref_s_s_cat	: '',

				isReferd    : false,
				forceload   : false,
				loading_text: 'Loading...',
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			if(this.slug){
				this.isReferd = true;
				this.divideSlug(JSON.parse(atob(this.slug)));
			}
			if(this.isReferd)
			this.reference()
			else
			this.http('shop/fetch/product', 'product');
		},
		methods:{
			filterBtn:function(){
				if(this.forMobile !=''){ this.forMobile = ''}
				else{ this.forMobile = 'open'}
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
			divideSlug:function(x){
				for(const key in x)
				{
					if(key=='category'){
						this.ref_cat = x[key];
					}
					else if(key=='sub_category'){
						ref_s_cat = x[key];
					}
					else if(key=='sub_sub_category'){
						ref_s_s_cat = x[key];
					}
				}
			},
			reference:function(){
				let forProduct 	= {};
				let brand_ids 	= {};
				let color_ids 	= {};
				let unit_ids 	= {};
				let size_ids 	= {};

				(this.ids.category 			? forProduct 	= {category:this.ids.category}:'');
				(this.ids.subcategory 		? forProduct 	= {category:this.ids.subcategory}:'');
				(this.ids.subsubcategory 	? forProduct 	= {category:this.ids.subsubcategory}:'');
				(this.ids.brand 			? brand_ids 	= {brand_ids:this.ids.brand}:'');
				(this.ids.color 			? color_ids 	= {color_ids:this.ids.color}:'');
				(this.ids.unit 				? unit_ids 		= {unit_ids:this.ids.unit}:'');
				(this.ids.size 				? size_ids 		= {size_ids:this.ids.size}:'');
				
				// Show Key which use for Searching

				(color_ids.color_ids.length > 0 ? this.http('shop/fetch/color', 'color', color_ids) : '');
				(size_ids.size_ids.length   > 0 ? this.http('shop/fetch/size', 'size', size_ids) 	: '');
				(unit_ids.unit_ids.length   > 0 ? this.http('shop/fetch/unit', 'unit', unit_ids) 	: '');
				(brand_ids.brand_ids.length > 0 ? this.http('shop/fetch/brand', 'brand', brand_ids) : '');



				this.http('shop/product/filter', 'product', forProduct);
				this.http('shop/fetch/searching/key', 'key', forProduct);
			},
			searchProduct:function(){
				let where = {
					color : this.colorM,
					size  : this.sizeM,
					brand : this.brandM,
					unit  : this.unitM,
					min   : (this.min != '' ? [this.min] : []),
					max   : (this.max != '' ? [this.max] : []),

					sort  			: (this.sort_amount != '' 	? [this.sort_amount] : []),
					category  		: (this.ids.category 		? this.ids.category : null),
					subcategory  	: (this.ids.subcategory 	? this.ids.subcategory : null),
					subsubcategory  : (this.ids.subsubcategory 	? this.ids.subsubcategory : null),
				}
				this.http('shop/product/filter', 'product', where);				
			},
			amountRang:function(){
				this.searchProduct();
			}
		},
		watch:{
			kernel:function(){
				for(let key in this.kernel){
					if(key == 'brand'){
						this.brands = this.kernel[key];	
					}
					else if(key == 'color'){
						this.colors = this.kernel[key];	
					}
					else if(key == 'size'){
						this.sizes = this.kernel[key];	
					}
					else if(key == 'product'){
						this.forceload = false;
						this.products = this.kernel[key];
						this.loading_text = ((this.products).length==0?"¯\\_(ツ)_/¯ Product Not Found...":false);
						var obj = this;
						setTimeout(function(){
							obj.forceload = true;
						}, 1);
					}
					else if(key == 'unit'){
						this.units = this.kernel[key];	
					}
					else if(key == 'key'){
						this.search_by = this.kernel[key];	
					}
				}
			},
			colorM:function(){
				this.searchProduct();
			},
			sizeM:function(){
				this.searchProduct();
			},
			brandM:function(){
				this.searchProduct();
			},
			unitM:function(){
				this.searchProduct();
			},
			sort_amount:function(){
				this.searchProduct();
			}
		}
	}
</script>