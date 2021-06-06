<template>
	<div class="panel-body">
		<form ref="form">
			<div class="row">
				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="Enter Sub Category Name">
					</div>
				</div> 

				<div class="col-3 col-md-12">
					<div class="form-group">
						<select v-model="cat_id" class="form-control" required="true">
							<option value="">-- Select Category --</option>
							<option v-for="category in categories" :value="category.id">{{ category.name }}</option>
						</select>
					</div>
				</div> 

				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="file" ref="fileInput" accept="image/*" @change="imageFile" class="form-control border-top-0"> 
					</div>
				</div>

				<div class="col-2 col-md-12">
					<div class="form-group">
						<div class="btn-group">
							<button class="btn btn-success radius-0 submit" @click="submit" :disable="btn" >
								<i :class="icon"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>

	<!-- Category List -->

		<div class="mt-5 position-relative">
			<div class="panel-head mb-1"><h2 class="title"><small>Sub Category List</small></h2></div>
			<div class="table-responsive">
				<table class="table" ref="table">
					<tr>
						<th width="70">SL</th>
						<th>Name</th>
						<th>Category</th>
						<th>Image</th>
						<th width="200" class="text-center">Action</th>
					</tr>
					<tr v-for="(subcategory, key) in subcategories">
						<td>{{ key+1 }}</td>
						<td>{{ subcategory.name }}</td>
						<td>{{ subcategory.category ? subcategory.category.name : 'N/A' }}</td>
						<td><img v-if="subcategories" :src="base_url+subcategory.image" height="30" :alt="subcategory.name"></td>
						<td v-on:load="loaded(key)">
				          	<div class="btn-group btn-margin justify-content-center w10">
					           	<button @click="erase(subcategory.id)" class="btn btn-trash btn-sml bg-warning delete-alert" title="Delete"><i class="fa fa-trash"></i></button>
					           	<button @click="edit(key)" class="btn btn-edit btn-sml bg-success" title="Edit"><i class="fa fa-pencil"></i></button>
				          	</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="caption" v-if="loader">
				<h4 v-if="loader=='nothing'">¯\_(ツ)_/¯ There Is Nothing </h4>
				<h4 v-else><span><i class="fa fa-spinner fa-spin"></i></span> Loading....</h4>
			</div>
		</div>

		<div v-if="edit_panel" class="slider-edit">
			<div class="form card">
				<div class="row d-flex justify-content-center">

					<div class="col-12">
						<div style="width: 200px;">
							<img class="responsive" :src="base_url+e_img" :alt="e_name">
						</div>
					</div>

					<div class="col-6 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_name" placeholder="Enter Category Name">
						</div>
					</div> 

					<div class="col-6 col-md-12">
						<div class="form-group">
							<select v-model="e_cat_id" class="form-control" required="true">
								<option value="">-- Select Category --</option>
								<option v-for="category in categories" :value="category.id">{{ category.name }}</option>
							</select>
						</div>
					</div> 

					<div class="col-10 col-md-12">
						<div class="form-group">
							<input type="file" ref="fileInput" accept="image/*" @change="imageFile" class="form-control border-top-0"> 
						</div>
					</div>

					<div class="col-2 col-md-12">
						<div class="form-group d-flex justify-content-end">
							<div class="btn-group">
								<button class="btn btn-success radius-0 submit" @click="update">
									<i :class="e_icon"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

				<button @click="close" class="close-btn">
					<i class="fa fa-close"></i>
				</button>

			</div>
		</div>
	</div>
</template>

<script>
	export default{
		name:'SubCategory',
		data(){
			return {
				base_url 	: '',
				kernel 		: {},
				name 		: '',
				cat_id 		: '',
				file 		: '',
				categories	: '',
				btn 		: false,
				icon 		: 'fa fa-check-square-o',
				id 		 	: '',
				edit_panel	: false,
				e_cat_id 	: '',
				e_name 		: '',
				e_icon 		: 'fa fa-check-square-o',
				e_img 		: '',
				e_index		: '',
				loader 		: true,
				subcategories	: '',
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			//Get All Sub Category
			this.http('admin/subcategory/all', 'subcategory');
			// Get All Category
			this.http('admin/category/all', 'category');
		},
		methods:{
			imageFile:function(event){
				this.file = event.target.files[0];
			},
			submit:function(event)
			{
				event.preventDefault();
				if(this.name != '' && this.file != '' && this.cat_id !=''){
					var data = this.$store.getters.formData({
						name  : this.name,
						image : this.file,
						cat_id: this.cat_id
					});
					this.icon = 'fa fa-spinner fa-spin';
					this.http('admin/subcategory/store', 'insert', data);
				}
				else{ warning('Title or image filed is required...') }
			},
			erase:function(id){
				this.http('admin/subcategory/delete/'+id, 'delete');
			},
			update:function(){
				if(this.e_name != '' && this.e_cat_id !=''){
					var data = this.$store.getters.formData({
						name : this.e_name,
						image : this.file,
						cat_id: this.e_cat_id
					});
					this.e_icon = 'fa fa-spinner fa-spin';
					this.http('admin/subcategory/update/'+this.id, 'update', data);
				}
				else{ warning('Title or image filed is required...') }
			},
			edit:function(index){
				this.edit_panel = true;
				this.e_name 	= this.subcategories[index].name;
				this.e_img 		= this.subcategories[index].image;
				this.id 		= this.subcategories[index].id;
				this.e_cat_id 	= this.subcategories[index].category ? this.subcategories[index].category.id : '';
				this.e_index 	= index;
			},
			reset:function(){
				this.name		= '';
				this.cat_id		= '';
				this.file		= '';
				this.e_name		= '';
				this.e_img		= '';
				this.e_cat_id	= '';
				this.file 		= '';
				this.icon 		= 'fa fa-check-square-o';
				this.e_icon 	= 'fa fa-check-square-o';
				this.$refs.fileInput.value = '';
			},
			close:function(){
				this.edit_panel = false;
				this.reset();
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
					if(key=='subcategory'){
						this.subcategories = this.kernel[key];
					}
					if(key=='insert'){
						this.subcategories = this.kernel[key];
						this.reset();
						success("Your Date Inserted Successfully..");
					}
					if(key=='update'){
						this.subcategories = this.kernel[key];
						this.close();
						success("Your Date Successfully Updated..");
					}
					if(key=='delete'){
						this.subcategories = this.kernel[key];
						success("Your Date Successfully Deleted..");
					}	
					if(key=='category'){
						this.categories = this.kernel[key];
					}				
				}
			},
			subcategories:function(){
				if((this.subcategories).length>0){
					this.loader = false;
				}else{
					this.loader = 'nothing';
				}
			}
		}
	}
</script>