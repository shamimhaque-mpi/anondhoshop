<template>
	<div class="panel-body min-height-80">
		<form ref="form">
			<div class="row">

				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="Enter Color Name">
					</div>
				</div> 

				<div class="col-3 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" v-model="code" placeholder="Enter Color Code">
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
			<div class="panel-title"><h2 class="title"><small>Color List</small></h2></div>
			<div class="table-responsive">
				<table class="table" ref="table">
					<tr>
						<th width="5%">SL</th>
						<th width="45%">Name</th>
						<th width="40%">Color Code</th>
						<th width="10%" class="text-center">Action</th>
					</tr>
					<tr v-for="(color, key) in colors">
						<td>{{ key+1 }}</td>
						<td>{{ color.name }}</td>
						<td>{{ color.code }}</td>
						<td>
				          	<div class="btn-group btn-margin justify-content-center w10">
					           	<button @click="erase(color.id)" class="btn btn-trash btn-sml bg-warning delete-alert" title="Delete"><i class="fa fa-trash"></i></button>
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
						<div class="color-box" :style="style">
						</div>
					</div>

					<div class="col-5 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_name" placeholder="Enter Color Name">
						</div>
					</div> 

					<div class="col-5 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_code" placeholder="Enter Color Code">
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
		name:'Color',
		data(){
			return {
				base_url 	: '',
				kernel 		: {},
				name 		: '',
				colors		: '',
				code		: '',
				btn 		: false,
				edit_panel	: false,
				id 		 	: '',
				e_name 		: '',
				e_code 		: '',
				icon 		: 'fa fa-check-square-o',
				e_icon 		: 'fa fa-check-square-o',
				e_index		: '',
				style 		: '',
				loader 		: true,
			}
		},
		mounted(){
			this.base_url = this.$store.state.site_url+'/';
			// Get All Category
			this.http('admin/color/all', 'color');
		},
		methods:{
			submit:function(event)
			{
				event.preventDefault();
				if(this.name != '' && this.code != ''){
					var data = this.$store.getters.formData({
						name : this.name,
						code : this.code,
					});
					this.icon = 'fa fa-spinner fa-spin';
					this.http('admin/color/store','store', data);
				}
				else{ warning('❗❗ Name or Color Code is required...'); }
			},
			update:function()
			{
				if(this.e_name != '' && this.e_code){
					var data = this.$store.getters.formData({
						name : this.e_name,
						code : this.e_code,
					});
					this.e_icon = 'fa fa-spinner fa-spin';
					this.http('admin/color/update/'+this.id, 'update', data);
				}
				else{ warning('❗❗ Name or Color Code is required...'); }
			},
			edit:function(index){
				this.edit_panel = true;
				this.e_name 	= this.colors[index].name;
				this.e_code		= this.colors[index].code;
				this.style 		= {backgroundColor : this.colors[index].code};
				this.id 		= this.colors[index].id;
				this.e_index 	= index;
			},
			reset:function(){
				this.name		= '';
				this.code		= '';
				this.e_code		= '';
				this.e_name		= '';
				this.e_index	= '';
				this.e_icon 	= 'fa fa-check-square-o';
				this.icon 		= 'fa fa-check-square-o';
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
			},
			erase:function(id){
				this.http('admin/color/delete/'+id, 'delete');
			},
			close:function(){
				this.edit_panel = false;
				this.reset();
			}
		},
		watch:{
			e_code:function(){
				this.style = {backgroundColor : this.e_code};
			},
			kernel:function(){
				for(const key in this.kernel){
					if(key == 'color'){
						this.colors = this.kernel[key];
					}
					else if(key == 'store'){
						this.colors = this.kernel[key];
						this.reset();
						success("Your Date Store Successful..");
					}
					else if(key == 'delete'){
						this.colors = this.kernel[key];
						warning("Your Date Delete Successful..");
					}
					else if(key == 'update'){
						this.colors = this.kernel[key];
						this.e_icon = 'fa fa-check-square-o';
						this.close();
						success("Your Date Update Successful..");
					}
				}
			},
			colors:function(){
				if((this.colors).length==0){
					this.loader = 'nothing';
				}else{
					this.loader = false;
				}
			}
		}
	}
</script>