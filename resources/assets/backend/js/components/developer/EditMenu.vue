<template>
    <div class="panel min-height-85">
		<div class="panel-title d-flex space-between">
			<h2 class="align-self-center title"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit Menu</h2> 
			<a :href="menu_list" class="btn-sml bg-success"><span><i class="fa fa-list-ul"></i>&nbsp;</span>List</a>	
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="label" for="name">Name(English) *</label>
						<input type="text" name="name_en" v-model="name_en" id="name_en" placeholder="Enter Menu Name" class="form-control">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="label" for="name">Name(Bangla)*</label>
						<input type="text" name="name_bn" v-model="name_bn" id="name_bn" placeholder="Enter Menu Name" class="form-control">
					</div>
				</div>	
				<div class="col-4">
					<div class="form-group">
						<label for="menu_type" class="label">Type *</label>
						<select name="menu_type" v-model="menu_type" class="form-control">
							<option disabled="true" value="">Select Menu Type</option>
							<option value="menu">Menu</option>
							<option value="sub_menu">Sub Menu</option>
							<option value="action_menu">Action Menu</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="parent_menu" class="label">Parent Menu {{ required_sign }} <span class="spering_loader" v-if="spering_loader">Loading..</span></label>
						<select name="parent_id" v-model="parent_id" class="form-control select2" id="parent_menu">
							<option disabled="true" value="">Select Parent Menu</option>
							<!-- <option v-for="menu in parent_menu_opt" v-bind:value="menu.id">{{ (menu.parent_name ? menu.parent_name+' / ' : '')+menu.name }}</option> -->
						</select>
					</div>
				</div>	
				<div class="col-4">
					<div class="form-group">
						<label class="label" for="url">Url {{ required_sign }}</label>
						<input type="text" name="url" v-model="url" placeholder="Enter URL" class="form-control">
					</div>
				</div>		
				<div class="col-4">
					<div class="form-group">
						<label for="route" class="label">Route {{ required_sign }}</label>
						<input type="text" name="route" value="" v-model="route" placeholder="Enter Route Nane" class="form-control">
					</div>
				</div>		
				<div class="col-4">
					<div class="form-group">
						<label for="icon" class="label">Icon *</label>
						<ul name="janina" class="select2 form-control" id="icon">
							<li value="" selected="true" disabled="true"> <span><i class="fa fa-fonticons"></i></span> &nbsp; Select a icon</li>
							<li :value="fontawesome" v-for="fontawesome in fonts"><span><i :class="fontawesome"></i></span> &nbsp; {{ fontawesome }}</li>
						</ul>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<div class="btn-group w10 d-block">
							<input type="submit" class="btn bg-success float-right radius-0" value="Update" @click="update">	
						</div>
					</div>
				</div>		
			</div>
		</div>		
	</div>
</template>

<script>
    export default {
    	name : 'EditMenu', 
    	props: ['fetch_url', 'update_url', 'csrf', 'menu_list', 'has_menu_type', 'has_menu_id', 's_m_fetch_url', 'fontawesomes'],
    	data(){
    		return {
    			name_en 		: "",
    			name_bn			: "",
				url    			: "",
				route  			: "",
				menu_type 		: "",
                previus_type    : "",
				parent_id 		: "",
				icon 			: "",
				required_sign	: "",
				parent_menu_opt : [],
				spering_loader 	: false,
				fonts 			: [],
    		}
    	},
        mounted() {
            console.log(this.update_url);
            this.$custom.getMessage();
            //
            this.menu_type      = this.has_menu_type;
            this.previus_type   = this.has_menu_type;
            //
            axios.post(this.s_m_fetch_url, 
            {
                menu_type : this.has_menu_type,
                id        : this.has_menu_id
            })
            .then(response=>{
                let sigle_menu  = response.data;
                this.parent_id  = sigle_menu.parent_id ? sigle_menu.parent_id : '';
                this.name_en    = sigle_menu.name_en;
                this.name_bn    = sigle_menu.name_bn;
                this.url        = sigle_menu.url;
                this.route      = sigle_menu.route;
                this.$selectOption.value('icon', sigle_menu.icon);
            })
            .catch(err=>console.log(err));

            this.fonts = JSON.parse(this.fontawesomes);
        },
    	watch:{
    		menu_type:function(){
				this.$selectOption.clearOption('parent_menu');
    			if(this.menu_type != "menu"){
    				this.required_sign = "*";
    				this.spering_loader= true;
    				axios.post(this.fetch_url, {
    					menu_type : this.menu_type,
    				})
    				.then(response => {
    					this.parent_menu_opt = response.data;
    					this.parent_menu_opt.forEach((x)=>{
    						this.$selectOption.newOption('parent_menu', ((x.parent_name ? x.parent_name+' / ' : '')+x.name_en), x.id);
    					});

		            	this.$selectOption.value('parent_menu', this.parent_id);
    					this.spering_loader  = false;
    				})
    				.catch(err => console.log(err));
    			}else{
    				this.parent_menu_opt = [];
    				this.required_sign 	 = "";  
    				this.parent_id 		 = "";
    				this.spering_loader  = false;  				
    			}
    		},
    		url:function()
    		{
                if(this.url){
        			let url 	= this.url;
        			if(url.indexOf('/') == 0)
        			{
        				url = url.slice(1);
        			}
        			if(url.indexOf('/', url.length-1) > 0)
        			{
        				url = url.slice(0, url.length-1);
        			}
        			this.route 	= url.split('/').join('.');
                }
    		}
    	},
    	methods:{
    		update:function(){
    			this.icon = this.$selectOption.value('icon');
    			this.parent_id 	= this.$selectOption.value('parent_menu');
    			if(this.name_en == "") {
					this.$message.warning('Name field is empty...!');
    			}
    			if(this.name_bn == "") {
					this.$message.warning('Name field is empty...!');
    			}
    			else if(this.menu_type == "") {
					this.$message.warning('Menu Type is empty...!');
    			}
    			else if(this.menu_type != "menu") 
    			{
					if(this.parent_id == ""){
						this.$message.warning('Parent Menu is empty...!');
					}
	    			else if(this.url == "") {
						this.$message.warning('URL field is empty...!');
	    			}
	    			else if(this.route == "") {
						this.$message.warning('Route field is empty...!');
	    			}
					else{
						this.dataUpdate();
					}
    			}
    			else if(this.icon == "") {
					this.$message.warning('Icon field is empty...!');
    			}
    			else {
    				this.dataUpdate();
    			}
    		},
    		dataUpdate:function(){
    			this.$custom.loader('on');
    			axios.post(this.update_url, {
    				name_bn		: this.name_bn,
    				name_en		: this.name_en,
    				url 		: this.url,
    				route 		: this.route,
    				parent_id 	: this.parent_id,
    				icon 		: this.icon,
    				menu_type 	: this.menu_type,
                    previus_type: this.previus_type,
    				_token 		: this.csrf,
    				id 			: this.has_menu_id
    			})
    			.then(response=>{
                    console.log(response.data);
    				if(response.data != ''){
    					this.$custom.setMessage('success', '✔ Successfully Updated..');
    					window.location.href = this.$store.state.site_url+'/developer/index';
    				}else{
						this.$message.warning(this.menu_type+' Not Inserted...!');
    				}
    			})
    			.catch(err=>console.log(err));
    		}
    	}
    }
</script>

<style scoped>
	.spering_loader{
		float: right;
		margin-right: 12px;
		color: red;
	}
</style>