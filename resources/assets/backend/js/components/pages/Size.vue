<template>
	<div class="panel-body">
		<form ref="form">
			<div class="row">

				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="Enter Size Name">
					</div>
				</div> 

				<div class="col-7 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="description" placeholder="Enter Short Description">
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
			<div class="panel-title"><h2 class="title"><small>Size List</small></h2></div>
			<div class="table-responsive">
				<table class="table" ref="table">
					<tr>
						<th width="70">SL</th>
						<th>Name</th>
						<th>Description</th>
						<th width="200" class="text-center">Action</th>
					</tr>
					<tr v-for="(size, key) in sizes">
						<td>{{ key+1 }}</td>
						<td>{{ size.name }}</td>
						<td>{{ size.description }}</td>
						<td>
				          	<div class="btn-group btn-margin justify-content-center w10">
					           	<button @click="erase(size.id)" class="btn btn-trash btn-sml bg-warning delete-alert" title="Delete"><i class="fa fa-trash"></i></button>
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
						<h3 class="title b-b w10 mt-5">Edit Size</h3>
					</div>
					<div class="col-12 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_name" placeholder="Enter Size Name">
						</div>
					</div> 

					<div class="col-12 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_description" placeholder="Enter Short Description">
						</div>
					</div>  

					<div class="col-12 col-md-12">
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
		name:'Size',
		data(){
			return {
				kernel 			: {},
				base_url 		: '',
				name 			: '',
				sizes			: '',
				description		: '',
				btn 			: false,
				icon 			: 'fa fa-check-square-o',
				id 		 		: '',
				edit_panel		: false,
				e_name 			: '',
				e_description 	: '',
				e_icon 			: 'fa fa-check-square-o',
				e_index			: '',
				loader 			: true,
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			// Get All Category
			this.http('admin/size/all', 'size');

		},
		methods:{
			submit:function(event)
			{
				event.preventDefault();
				if(this.name != '' && this.description != ''){
					var data = this.$store.getters.formData({
						name 		: this.name,
						description : this.description,
					});
					this.loader = true;
					this.icon   = 'fa fa-spinner fa-spin';
					this.http('admin/size/store', 'save', data);
				}
				else{ warning('❗❗ Name or description field is required...') }
			},
			erase:function(id){
				this.http('admin/size/delete/'+id, 'delete');
			},
			close:function(){
				this.edit_panel = false;
				this.reset();
			},
			update:function()
			{
				if(this.e_name != '' && this.e_description){
					var data = this.$store.getters.formData({
						name : this.e_name,
						description : this.e_description,
					});
					this.e_icon = 'fa fa-spinner fa-spin';
					this.http('admin/size/update/'+this.id, 'update', data);
				}
				else{ warning('❗❗ Name or description field is required...') }
			},
			edit:function(index){
				this.edit_panel 	= true;
				this.e_name 		= this.sizes[index].name;
				this.e_description	= this.sizes[index].description;
				this.id 			= this.sizes[index].id;
				this.e_index 		= index;
			},
			reset:function(){
				this.name			= '';
				this.description	= '';
				this.e_description	= '';
				this.e_name			= '';
				this.icon 			= 'fa fa-check-square-o';
				this.e_icon 		= 'fa fa-check-square-o';
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
					if(key == 'size'){
						this.sizes = this.kernel[key];
						this.loader = false;
					}
					if(key == 'save'){
						this.sizes = this.kernel[key];
						this.loader = false;
						this.reset();
						success('Your Data Successfully Inserted..');
					}
					if(key == 'delete'){
						this.sizes = this.kernel[key];
						this.loader = false;
						success('Your Data Delete Successful..');
					}
					if(key == 'update'){
						this.sizes = this.kernel[key];
						this.loader = false;
						this.reset();
						this.edit(this.e_index);
						success('Your Data Successfully Updated..');
					}
				}
			},
			sizes:function(){
				if((this.sizes).length == 0){
					this.loader = 'nothing';
				}
			}
		}
	}
</script>