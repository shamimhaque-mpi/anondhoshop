<template>
	<div class="panel-body">
		<form ref="form">
			<div class="row">

				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="Enter Brand Name">
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
			<div class="panel-title"><h2 class="title"><small>Brand List</small></h2></div>
			<div class="table-responsive">
				<table class="table" ref="table">
					<tr>
						<th width="70">SL</th>
						<th>Name</th>
						<th>Image</th>
						<th width="200" class="text-center">Action</th>
					</tr>
					<tr v-for="(brand, key) in brands">
						<td>{{ key+1 }}</td>
						<td>{{ brand.name }}</td>
						<td><img v-if="brands" :src="base_url+brand.image" height="30" :alt="brand.name"></td>
						<td>
				          	<div class="btn-group btn-margin justify-content-center w10">
					           	<button @click="erase(brand.id)" class="btn btn-trash btn-sml bg-warning delete-alert" title="Delete"><i class="fa fa-trash"></i></button>
					           	<button @click="edit(key)" class="btn btn-edit btn-sml bg-success" title="Edit"><i class="fa fa-pencil"></i></button>
				          	</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="caption" v-if="loader">
				<h4 v-if="loader=='nothing'"> There Is Nothing </h4>
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

					<div class="col-12 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_name" placeholder="Enter Brand Name">
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
		name:'Brand',
		data(){
			return {
				base_url 	: '',
				kernel 		: {},
				name 		: '',
				file 		: '',
				brands		: '',
				btn 		: false,
				icon 		: 'fa fa-check-square-o',
				id 		 	: '',
				edit_panel	: false,
				e_name 		: '',
				e_icon 		: 'fa fa-check-square-o',
				e_img 		: '',
				e_index		: '',
				loader 		: true,
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			// Get All Category
			this.http('admin/brand/all', 'brand');

		},
		methods:{
			imageFile:function(event){
				this.file = event.target.files[0];
			},
			submit:function(event){
				event.preventDefault();
				if(this.name != '' && this.file != ''){
					var data = this.$store.getters.formData({
						name  : this.name,
						image : this.file
					});
					
					this.icon = 'fa fa-spinner fa-spin';
					this.loader = true;
					this.http('admin/brand/store', 'brand', data);
					this.reset();
				}
				else{ warning('Title or image filed is required...') }
			},
			erase:function(id){
				this.http('admin/brand/delete/'+id, 'delete');
			},
			close:function(){
				this.edit_panel = false;
				this.reset();
			},
			update:function(){
				
				if(this.e_name != ''){
					var data = this.$store.getters.formData({
						name  : this.e_name,
						image : this.file,
					});
					this.e_icon = 'fa fa-spinner fa-spin';
					this.loader = true;
					this.http('admin/brand/update/'+this.id, 'update', data);
				}
				else{ warning('Title or image filed is required...') }
			},
			edit:function(index){
				this.edit_panel = true;
				this.e_name 	= this.brands[index].name;
				this.e_img 		= this.brands[index].image;
				this.id 		= this.brands[index].id;
				this.e_index 	= index;
			},
			reset:function(){
				this.name		= '';
				this.cat_id		= '';
				this.file		= '';
				this.icon 		= 'fa fa-check-square-o';
				this.$refs.fileInput.value = '';
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
					if(key == 'brand'){
						this.brands = this.kernel[key];
					}
					if(key == 'delete'){
						this.brands = this.kernel[key];
						success('Your Data Successfully Deleted..');
					}
					if(key == 'update'){
						this.brands = this.kernel[key];
						this.close();
						success("Your Date Update Successful..");
					}
				}
			},
			brands:function(){
				if((this.brands).length==0){
					this.loader = 'nothing';
				}else{
					this.loader = false;
				}
			}
		}
	}
</script>