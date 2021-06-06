<template>
	<div class="position-relative">
		<form action="#" v-on:submit.prevent="submit" >
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label class="label">Name <strong class="required">*</strong></label>
						<input type="text" v-model="name" class="form-control" placeholder="Enter Product Name" required="true">
					</div>
				</div>

				<div class="col-3 col-md-12">
					<div class="form-group">
						<label class="label">Brand <strong class="required">*</strong></label>
						<select v-model="brand_id" class="form-control" required="true">
							<option value="">-- Select Brand --</option>
							<option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>	
						</select>
					</div>
				</div>

				<div class="col-3 col-md-12">
					<div class="form-group">
						<label class="label">Category <strong class="required">*</strong></label>
						<select v-model="cat_id" id="cat_id" class="form-control" multiple="true" required="true">
							<option value="">-- Select Category --</option>
							<option v-for="category in categories" :value="category.id">{{ category.name }}</option>
						</select>
					</div>
				</div>

				<div class="col-3 col-md-12">
					<div class="form-group">
						<label class="label">Sub Category </label>
						<select v-model="sub_cat_id" multiple="true" class="form-control">
							<option value="">-- Select Sub Category --</option>
							<option v-for="subcate in subcategories" :value="subcate.id"> {{subcate.name}} </option>
						</select>
					</div>
				</div>

				<div class="col-3 col-md-12">
					<div class="form-group">
						<label class="label">Sub Sub Category </label>
						<select v-model="sub_sub_cat_id" multiple="true" class="form-control">
							<option value="">-- Select Sub Sub Category --</option>
							<option v-for="subsubcategory in subsubcategories" :value="subsubcategory.id"> {{ subsubcategory.name }} </option>
						</select>
					</div>
				</div>
			</div>

			<div class="br"></div>

			<div class="row">

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Product Unit <strong class="required">*</strong></label>
						<select v-model="unit_id" class="form-control" required="true">
							<option value="">-- Select Unit --</option>
							<option v-for="unit in units" :value="unit.id"> {{ unit.name }} </option>
						</select>
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Min Sale Quantity <strong class="required">*</strong></label>
						<input type="number" step="any" v-model="min_sale_quantity" placeholder="Min Sale Quantity" class="form-control" required="true">
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Purchase Price <strong class="required">*</strong></label>
						<input type="number" step="any" placeholder="Purchase Price" v-model="purchase_price" class="form-control" required="true">
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Regular Price <strong class="required">*</strong></label>
						<input type="number" step="any" placeholder="Regular Price" v-model="regular_price" class="form-control" required="true">
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Discount(%)</label>
						<input type="number" step="any" v-model="discountPersentige" placeholder="Ex: 30 (30%)" class="form-control">
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Discount(Flat)</label>
						<input type="number" step="any" v-model="discountFlat" placeholder="Ex: 300(Amount)" class="form-control">
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">F-Sale Price <strong class="required">*</strong></label>
						<input type="number" step="any" v-model="present_sale_price" placeholder="Product Price" class="form-control"  required="true" readonly="true">
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Total Discount <strong class="required">*</strong></label>
						<input type="number" step="any" v-model="total_dis_pers" placeholder="Product Price" class="form-control"  required="true" readonly="true">
					</div>
				</div>
			</div>

			<div class="br"></div>

			<div class="row">
				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Color</label>
						<select class="form-control" v-model="m_color" multiple="true">
							<option value="">-- Select A Color --</option>
							<option v-for="color in colors" :value="color.id"> {{ color.name }} </option>
						</select>
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<label class="label">Size</label>
						<select class="form-control" v-model="m_size" multiple="true">
							<option value="">-- Select A Size --</option>
							<option v-for="size in sizes" :value="size.id"> {{ size.name }} </option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<h3 class="title w10 b-b bm-1 mt-5">Product Description....</h3>
				</div>
				<div class="col-12">
					<textarea class="form-control" v-model="description" placeholder="Write Your Product Description" rows="18"></textarea>
				</div>	
			</div>

			<div class="row" v-if="!required">
				<div class="col-12">
					<h3 class="title w10 b-b bm-1 mt-5">Images</h3>
				</div>
				<div class="col-12">
					<div class="row">
						<!-- sigle image -->
						<div class="col-2 col-md-6" v-for="(image, index) in images">
							<div class="form-group" v-if="(m_color.length > 0) && (m_color[0] != '')">
								<select class="form-control" :value="image.color" @change="setImageColor(index, $event.target.value)">
									<option value="">-- Select A Color --</option>
									<option v-for="color in colors" v-if="m_color.indexOf(color.id) > -1" :value="color.id"> {{ color.name }} </option>
								</select>
							</div>
							<div class="form-group" v-if="(m_size.length > 0) && (m_size[0] != '')">
								<select class="form-control" :value="image.size" @change="setImageSize(index, $event.target.value)">
									<option value="">-- Select A Size --</option>
									<option v-for="size in sizes" v-if="m_size.indexOf(size.id) > -1" :value="size.id"> {{ size.name }} </option>
								</select>
							</div>
							<div class="image">
								<img :src="image.src" class="responsive">
								<span class="remove" @click="imageRemove(index)">
									<i class="fa fa-trash"></i>
								</span>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="br"></div>

			<div class="row">
				<div class="col-4 col-md-12">
					<div class="form-group">
						<label class="label"> {{ required ? 'Select Product Image' : 'Select Another Image' }} <strong v-if="required" class="required">*</strong></label>
						<input type="file" @change="image" ref="file" class="form-control" :required="required">
					</div>
				</div>

				<div class="col-8 col-md-12">
					<div class="form-group w10 d-block">
						<button class="btn btn-success radius float-right submit"><i :class="icon"></i></button>
					</div>
				</div>
			</div>
		</form>
		<div class="caption" v-if="loader">
			<h4><span><i class="fa fa-spinner fa-spin"></i></span> Loading....</h4>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'Product',
		props:['product_id'],
		data(){
			return {
				required 			: true,
				loader 				: true,
				kernel 				: {},
				brands 				: [],
				base_url 			: '',
				categories 			: [],
				subcategories 		: [],
				subsubcategories 	: [],
				colors 				: '',
				sizes 				: '',
				units 				: [],

				name 				: '',
				brand_id 			: '',
				cat_id 				: [],
				sub_cat_id 			: [],
				sub_sub_cat_id 		: [],
				purchase_price 		: '',
				regular_price		: '',
				min_sale_quantity 	: '',
				unit_id 			: '',
				m_color 			: [],
				m_size 				: [],
				description 		: '',
				images 				: [],

				discountPersentige 	: 0,
				discountFlat 		: 0,
				present_sale_price	: 0,
				icon 				: 'fa fa-check-square-o',
				isEdit 				: false,
				total_dis_pers 		: 0,
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			this.http('admin/brand/all', 'brand');
			this.http('admin/category/all', 'category');
			this.http('admin/color/all', 'color');
			this.http('admin/size/all', 'size');
			this.http('admin/unit/all', 'unit');
			if(this.product_id){
				this.isEdit = true;
				this.http('admin/product/find/'+this.product_id, 'EditProduct');
			};
		},
		methods:{
			submit:function()
			{
				this.icon 	= 'fa fa-spinner fa-spin';
				this.loader = true;
				loader('on');
				let data = new FormData();
				let otherInfo = {
					name 				: this.name,
					brand_id 			: this.brand_id,
					cat_id 				: this.cat_id,
					sub_cat_id 			: this.sub_cat_id,
					sub_sub_cat_id 		: this.sub_sub_cat_id,
					purchase_price 		: this.purchase_price,
					regular_price 		: this.regular_price,
					min_sale_quantity 	: this.min_sale_quantity,
					discount_persentige	: this.discountPersentige,
					discount_flat 		: this.discountFlat,
					present_sale_price 	: this.present_sale_price,
					unit_id 			: this.unit_id,
					m_color 			: this.m_color,
					m_size 				: this.m_size,
					description 		: this.description,
					total_dis_pers		: this.total_dis_pers,
					img_info 			: JSON.stringify(this.images),
				};
				for(const img in this.images){
					if(this.images[img].file){
						data.append('image[]', this.images[img].file);
					}					
				}
				for(const info in otherInfo){
					data.append(info, otherInfo[info]);
				}
				if(this.isEdit!=true){
					this.http('admin/product/store','product', data);
				}
				else{
					this.http('admin/product/update/'+this.product_id,'product', data);
				}
			},
			image:function(event){
				let file = event.target.files[0];
				if(typeof file != 'undefined'){
					this.images.push({
						color : '',
						size  : '',
						src   : URL.createObjectURL(event.target.files[0]),
						'file': file
					});
				}
			},
			imageRemove:function(index){
				let images = this.images;
				if(this.isEdit && typeof(images[index].img_id)!=='undefined'){
					this.http('admin/product/image/delete/'+images[index].img_id, 'image');
				}
				this.images = this.$store.getters.arrayValueRemove(this.images, index);
			},
			setImageColor:function(key, color){
				this.images[key].color = color;
			},
			setImageSize:function(key, size){
				this.images[key].size = size;
			},
			editProduct:function(item){
				this.name 				= item.name;
				this.brand_id 			= item.brand_id;
				this.description 		= item.description;
				this.purchase_price		= item.purchase_price;
				this.regular_price		= item.regular_price;
				this.min_sale_quantity	= item.min_sale_quantity;
				this.discountPersentige = item.discount_persentige;
				this.discountFlat 		= item.discount_flat;
				this.present_sale_price	= item.present_sale_price;
				this.unit_id			= item.unit_id;
				let vueObj 				= this;

				/* -------------Category----------------- */
				async function specification(){
					(item.category_id).forEach(function(value){
						(vueObj.cat_id).push(value.category_id);
					});
				}
				/* ---------------SubCategory-------------- */
				specification().then(function(){
					(item.subcategory_id).forEach(function(value){
						(vueObj.sub_cat_id).push(value.sub_category_id);
					});
				})
				/* ---------------SubSubCategory-------------- */
				.then(function(){
					(item.subsubcategory_id).forEach(function(value){
						(vueObj.sub_sub_cat_id).push(value.sub_sub_category_id);
					});
				})
				/* ---------------------Color------------------ */
				.then(function(){
					(item.color_id).forEach(function(value){
						(vueObj.m_color).push(value.color_id);
					});
				})
				/*-----------------------Size--------------------*/
				.then(function(){
					(item.size_id).forEach(function(value){
						(vueObj.m_size).push(value.size_id);
					});
				})
				/*----------------------Images-------------------*/
				.then(function(){
					(item.image).forEach(function(value){
						vueObj.images.push(
						{
							img_id : value.id,
							pd_id  : value.product_id,
							src    : vueObj.base_url+value.small,
							color  : value.color_id,
							size   : value.size_id,
						});
					});
				});
			},
			remission:function(){
				let regular_price 		= +this.regular_price;
				let discountPersentige 	= +this.discountPersentige;
				let discountFlat 		= +this.discountFlat;

				let remission 			= ((regular_price/100)*discountPersentige);
				this.present_sale_price	= (regular_price - (discountFlat+remission));

				this.total_dis_pers 	= ((100/regular_price)*(discountFlat+remission));
			},
			http:function(url, type, data=null){
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
						 if(key == 'brand'){ this.brands = this.kernel[key]; }
					else if(key == 'color'){ this.colors = this.kernel[key]; }
					else if(key == 'size') { this.sizes  = this.kernel[key]; }
					else if(key == 'unit') { this.units  = this.kernel[key]; }

					else if(key == 'category'){
						this.categories = this.kernel[key];
						let load = this;
						setTimeout(function(){
							load.loader = false;
						},150);
					}
					else if(key == 'product'){
						window.location.href = this.base_url+'admin/product/view/'+this.kernel[key];
					}
					else if(key == 'EditProduct'){ 
						this.editProduct(this.kernel[key]); 
					}
				}
			},
			cat_id:function()
			{
				let categories 		= this.categories;
				this.sub_cat_id 	= [];
				this.subcategories 	= [];
				let cat_id 			= this.cat_id;

				for(const key in categories){
					for(const key2 in cat_id){
						if(categories[key].id == cat_id[key2]){
							if(typeof (categories[key].sub_category) != 'undefined'){
								this.subcategories = [...categories[key].sub_category, ...this.subcategories];
							}
						}
					};
				}
			},
			sub_cat_id:function()
			{
				let subcategories 	  = this.subcategories;
				this.sub_sub_cat_id   = [];
				this.subsubcategories = [];

				let sub_cat_id = this.sub_cat_id;
				for(const key in subcategories){
					for(const key2 in sub_cat_id){
						if(subcategories[key].id == sub_cat_id[key2]){
							if(typeof(subcategories[key].sub_sub_category) != 'undefined'){
								this.subsubcategories = [...subcategories[key].sub_sub_category, ...this.subsubcategories];
							}
						}
					}
				}
			},
			images:function(){
				if(this.images.length > 0){
					this.required = false;
				}else{
					this.required = true;
					this.$refs.file.value = '';
				}
			},
			m_size:function(){
				for(const img in this.images){
					if((Object.values(this.m_size)).indexOf(+this.images[img].size) < 0){
						this.images[img].size = '';
					}
				}
			},
			m_color:function(){
				for(const img in this.images){
					if((Object.values(this.m_color)).indexOf(+this.images[img].color) < 0){
						this.images[img].color = '';
					}
				}
			},
			discountFlat:function(){
				this.remission();
			},
			discountPersentige:function(){
				this.remission();
			},
			regular_price:function(){
				this.remission();
			}
		}
	}
</script>