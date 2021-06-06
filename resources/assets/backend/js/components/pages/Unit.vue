<template>
	<div class="panel-body">
		<form ref="form">
			<div class="row">

				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="Enter Unit Name">
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

		<div class="mt-5">
			<div class="panel-title"><h2 class="title"><small>Unit List</small></h2></div>
			<div class="table-responsive">
				<table class="table" ref="table">
					<tr>
						<th width="70">SL</th>
						<th>Name</th>
						<th>Description</th>
						<th width="200" class="text-center">Action</th>
					</tr>
					<tr v-for="(unit, key) in units">
						<td>{{ key+1 }}</td>
						<td>{{ unit.name }}</td>
						<td>{{ unit.description }}</td>
						<td>
				          	<div class="btn-group btn-margin justify-content-center w10">
					           	<button @click="erase(unit.id)" class="btn btn-trash btn-sml bg-warning delete-alert" title="Delete"><i class="fa fa-trash"></i></button>
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
						<h3 class="title b-b w10 mt-5">Edit Unit</h3>
					</div>
					<div class="col-12 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_name" placeholder="Enter Unit Name">
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
		name:'Unit',
		data(){
			return {
				base_url 		: '',
				kernel 			: {},
				name 			: '',
				units			: '',
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
			this.http('admin/unit/all', 'unit');
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
					this.icon = 'fa fa-spinner fa-spin';
					this.http('admin/unit/store', 'insert', data);
				}
				else{ warning('❗❗ Name or description field is required...') }
			},
			erase:function(id){
				this.http('admin/unit/delete/'+id, 'delete');
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
					this.http('admin/unit/update/'+this.id, 'update', data);
				}
				else{ warning('❗❗ Name or Color Code is required...') }
			},
			edit:function(index){
				this.edit_panel 	= true;
				this.e_name 		= this.units[index].name;
				this.e_description	= this.units[index].description;
				this.id 			= this.units[index].id;
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
					if(key == 'unit'){
						this.units  = this.kernel[key];
						this.loader = false;
					}
					if(key == 'insert'){
						this.units  = this.kernel[key];
						this.loader = false;
						this.reset();
						success("Your Date Successfully inserted..");
					}
					if(key == 'delete'){
						this.units  = this.kernel[key];
						this.loader = false;
						success("Your Date delete Successful..");
					}
					if(key == 'update'){
						this.units  = this.kernel[key];
						this.loader = false;
						this.close();
						success("Your Date delete Successful..");
					}
				}
			},
			units:function(){
				if((this.units).length==0){
					this.loader = 'nothing';
				}
			}
		}
	}
</script>