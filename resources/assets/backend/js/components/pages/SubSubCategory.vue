<template>
	<div class="panel-body">
		<form ref="form">
			<div class="row">
				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="Enter Sub Sub Category Name">
					</div>
				</div> 

				<div class="col-3 col-md-12">
					<div class="form-group">
						<select v-model="cat_id" class="form-control" required="true">
							<option value="">-- Select Sub Category --</option>
							<option v-for="subcategory in subcategories" :value="subcategory.id">{{ subcategory.name }}</option>
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
			<div class="panel-head mb-1"><h2 class="title"><small>Sub Sub Category List</small></h2></div>
			<div class="table-responsive">
				<table class="table" ref="table">
					<tr>
						<th width="70">SL</th>
						<th>Name</th>
						<th>Sub Category</th>
						<th>Image</th>
						<th width="200" class="text-center">Action</th>
					</tr>
					<tr v-for="(subsubcategory, key) in subsubcategories">
						<td>{{ key+1 }}</td>
						<td>{{ subsubcategory.name }}</td>
						<td>{{ subsubcategory.sub_category ? subsubcategory.sub_category.name : 'N/A' }}</td>
						<td><img v-if="subsubcategories" :src="site_url+subsubcategory.image" height="30" :alt="subsubcategory.name"></td>
						<td>
				          	<div class="btn-group btn-margin justify-content-center w10">
					           	<button @click="erase(subsubcategory.id)" class="btn btn-trash btn-sml bg-warning delete-alert" title="Delete"><i class="fa fa-trash"></i></button>
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
							<img class="responsive" :src="site_url+e_img" :alt="e_name">
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
								<option v-for="subcategory in subcategories" :value="subcategory.id">{{ subcategory.name }}</option>
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
		name:'SubSubCategory',
		data(){
			return {
				site_url 			: '',
				name 				: '',
				cat_id 				: '',
				file 				: '',
				subsubcategories	: '',
				subcategories		: '',
				btn 				: false,
				icon 				: 'fa fa-check-square-o',
				id 		 			: '',
				edit_panel			: false,
				e_cat_id 			: '',
				e_name 				: '',
				e_icon 				: 'fa fa-check-square-o',
				e_img 				: '',
				e_index				: '',
				loader 				: true,
			}
		},
		mounted(){
			this.site_url = this.$store.state.site_url+'/';

			//Get All Sub Category
			axios.post(this.site_url+'admin/subsubcategory/all')
			.then(response=>{
				if(typeof(response) != 'undefined'){
					this.subsubcategories = response.data;
				}
			})
			.then(err=>(typeof(err) != 'undefined' ? console.log(err) : ''));

			// Get All Category
			axios.post(this.site_url+'admin/subcategory/all')
			.then(response=>{
				if(typeof(response) != 'undefined'){
					this.subcategories = response.data;
				}
			})
			.then(err=>(typeof(err) != 'undefined' ? console.log() : ''));
		},

		methods:{
			imageFile:function(event){
				this.file = event.target.files[0];
			},

			submit:function(event)
			{
				event.preventDefault();
				if(this.name != '' && this.file != '' && this.cat_id !=''){
					var data = this.$store.getters.formData(
					{
						name 		: this.name,
						image 		: this.file,
						sub_cat_id 	: this.cat_id
					});
					this.icon = 'fa fa-spinner fa-spin';
					
					axios.post(this.site_url+'admin/subsubcategory/store', data)
					.then(response=>{
						if(typeof(response) != 'undefined'){
							this.subsubcategories 	= response.data;
							this.file 			= '';
							this.icon 			= 'fa fa-check-square-o';
							this.reset();
							success("✔ Your Date Save Successful..");
						}
					})
					.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
				}
				else{
					warning('❗❗ Title, Sub Category Or Image Riled Is Required...!');
				}
			},
			// Delete Data from Table
			erase:function(id)
			{
				axios.delete(this.site_url+'admin/subsubcategory/delete/'+id)
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.subsubcategories = response.data;
					}
				})
			},
			//Table Update
			update:function(){
				if(this.e_name != '' && this.e_cat_id !='')
				{
					this.e_icon = 'fa fa-spinner fa-spin';
					// Make Form Data
					var data = this.$store.getters.formData(
					{
						name 		: this.e_name,
						image 		: this.file,
						sub_cat_id	: this.e_cat_id
					});
					// Axios
					axios.post(this.site_url+'admin/subsubcategory/update/'+this.id, data)
					.then(response=>{
						if(typeof(response) != 'undefined')
						{
							this.subsubcategories 	= response.data;
							this.file 				= '';
							this.e_icon 			= 'fa fa-check-square-o';

							this.edit(this.e_index);
							success("✔ Your Date Update Successful..");
						}
					})
					.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
				}
				else{
					warning('❗❗ Title Or Sub Category Riled Is Required...!');
				}
			},
			// Open Edit Panel
			edit:function(index)
			{
				this.edit_panel = true;
				this.e_name 	= this.subsubcategories[index].name;
				this.e_img 		= this.subsubcategories[index].image;
				this.id 		= this.subsubcategories[index].id;
				this.e_cat_id 	= this.subsubcategories[index].sub_category ? this.subsubcategories[index].sub_category.id : '';
				this.e_index 	= index;
			},
			//close Edit panel
			close:function()
			{
				this.edit_panel = false;
				this.reset();
			},
			// Reset Form Data
			reset:function()
			{
				this.name		= '';
				this.cat_id		= '';
				this.file		= '';
				this.e_name	= '';
				this.e_img		= '';
				this.e_cat_id	= '';
				this.e_index	= '';
				this.$refs.fileInput.value = '';
			}
		},
		watch:{
			subsubcategories:function(){
				if((this.subsubcategories).length>0){
					this.loader = false;
				}else{
					this.loader = 'nothing';
				}
			}
		}
	}
</script>