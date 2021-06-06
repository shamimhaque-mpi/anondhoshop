<template>
	<div class="panel-body">
		<div class="row d-flex justify-content-center">

			<div class="col-5 col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" v-model="title" placeholder="Enter Category Name">
				</div>
			</div> 

			<div class="col-5 col-md-12">
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

		<!-- Gellary -->
		<div class="row">
			<div class="col-12 text-center">
				<h1 class="w10 p-3 mb-3 title b-b text-center">Images Gellary</h1>
			</div>

			<div class="col-3" v-for="(item, index) in group">
				<div class="card g-image">
					<div class="w10" style="height: 120px">
						<img if="item.img" v-bind:src="site_url+(item.img)"  class="responsive" :alt="item.title">
					</div>
					<div class="w10 d-flex space-between">
						<p class="slider-title">{{ item.title }}</p>
						<div class="btn-group">
							<button @click="edit(index)" class="btn btn-sml btn-success">
								<i class="fa fa-pencil"></i>
							</button>
							<button @click="dust(item.id)" class="btn btn-sml bg-warning">
								<i class="fa fa-trash"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div v-if="edit_panel" class="slider-edit">
			<div class="form card">
				<div class="row d-flex justify-content-center">
					<div class="col-12">
						<div>
							<img class="responsive" :src="site_url+e_img" :alt="e_title">
						</div>
					</div>
					<div class="col-5 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" v-model="e_title" placeholder="Enter Category Name">
						</div>
					</div> 

					<div class="col-5 col-md-12">
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
	export default {
		name: 'Slider',
		data(){
			return{
				formdata 	: new FormData(),
				site_url 	: '',
				title 		: '',
				file 		: '',
				group 		: '',
				btn 		: false,
				icon 		: 'fa fa-check-square-o',
				edit_panel	: false,
				e_title 	: '',
				e_icon 		: 'fa fa-check-square-o',
				e_img 		: '',
				e_id 		: '',
				e_index		: '',
			}
		},
		mounted(){
			this.site_url = this.$store.state.site_url+"/";
			axios.get(this.site_url+'/admin/slider/all/data')
			.then(response=>{
				this.group = response.data;
			})
			.then(err=>console.log(err));
		},
		methods:{
			imageFile:function(event)
			{
				this.file = event.target.files[0];
			},

			submit:function()
			{
				if(this.title == '' || typeof(this.file) === 'undefined'){
					window.warning("‼ Title or file is required ");
				}
				else{
					this.icon = 'fa fa-spinner fa-spin';
					this.formdata.append('img', this.file);
					this.formdata.append('title', this.title);
					axios.post(this.site_url+'/admin/slider/store', this.formdata)
					.then(response=>{
						this.group 	= response.data;
						this.icon 	= 'fa fa-check-square-o';
						this.title 	= '';
						this.file 	= '';
						this.$refs.fileInput.value = '';	
						window.success("✔ Slider Image Save Successfull.... ");
					})
					.then(err=>console.log(err));
				}
			},

			dust:function(id){
				axios.get(this.site_url+'admin/slider/delete/'+id)
				.then(response=>{
					this.group = response.data;
					window.warning("✔ Slider Image Delete Successfull.... ");
				})
				.then(err=>console.log(err));
			},

			edit:function(id){
				this.edit_panel = true;
				this.e_id		= this.group[id].id;
				this.e_img		= this.group[id].img;
				this.e_title	= this.group[id].title;
				this.e_index	= id;
			},

			update:function()
			{
				this.e_icon = 'fa fa-spinner fa-spin';
				this.formdata.append('img', this.file);
				this.formdata.append('title', this.e_title);
				axios.post(this.site_url+'/admin/slider/update/'+this.e_id, this.formdata)
				.then(response=>{
					this.group 	 = response.data;
					this.e_icon	 = 'fa fa-check-square-o';
					this.file 	 = '';
					this.$refs.fileInput.value = '';	
					this.e_img	 = this.group[this.e_index].img;
					window.success("✔ Slider Image Save Successfull.... ");
				})
				.then(err=>console.log(err));
			},

			close:function(){
				this.edit_panel = false;
				this.e_title = '';
			}
		}
	}
</script>