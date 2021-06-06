<template>
	<div class="user-profile-panel">
      <div class="imfortent-info">

        <div class="info">

          <div class="user-cover">
            <div class="inner-cover">
              <img v-if="profile_pic" :src="url+'/'+profile_pic" alt="">
              <div class="new-picture">
                <label for="new_picture" class="d-flex align-items-center justify-content-center">
                  <input type="file" id="new_picture" @change="image">
                  <i class="fa fa-upload"></i>
                </label>
              </div>
              <div class="user-name">
                <input type="text" v-model="name" placeholder="Nick Name" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="user-contract-into">

            <div class="form-group-user position-relative">
              <label for="phone"><span><i class="fa fa-phone-square"></i></span>&nbsp;Phone <span class="text-warning">*</span></label>
              <input type="phone" v-model="mobile" autocomplete="off">
            </div>
              
            <div class="form-group-user">
              <label for="email"><span><i class="fa fa-google-plus-square"></i></span>&nbsp;E-mail <span class="text-warning">*</span></label>
              <input type="email" v-model="email" placeholder="example@mail.com" autocomplete="off">
            </div>
              
            <div class="form-group-user">
              <label for="facebook"><span><i class="fa fa-facebook-square"></i></span>&nbsp;Facebook</label>
              <input type="text" v-model="facebook" placeholder="facebook.com" autocomplete="off">
            </div>
              
            <div class="form-group-user">
              <label for="twitter"><span><i class="fa fa-twitter-square "></i></span>&nbsp;Twitter</label>
              <input type="text" v-model="twitter" placeholder="Twitter.com" autocomplete="off">
            </div>
              
            <div class="form-group-user">
              <label for="linkedin"><span><i class="fa fa-twitter-square "></i></span>&nbsp;Linkedin</label>
              <input type="text" v-model="linkedin" placeholder="Linkedin.com" autocomplete="off">
            </div>
              
            <div class="form-group-user mb-2">
              <label for="youtube"><span><i class="fa fa-youtube-square "></i></span>&nbsp;Youbute</label>
              <input type="text" v-model="youtube" placeholder="Youtube.com" autocomplete="off">
            </div>

          </div>
           
        </div>

      </div>
      <div class="basic-info">
        <div class="info">
          <div class="row">
            <div class="col-12 p-0 border-bottom background">
              <span class="username d-block p-3 float-right text-right">{{ username }}<span class="strong"> #</span></span>
            </div>

            <div class="col-12 mt-3 p-3 pb-0">
              <div class="form-group">
                <label for="address" class="label">Address</label>
                <input type="text" v-model="address" id="address" class="form-control" placeholder="Write Your Address"  autocomplete="off">
              </div>
            </div>

            <div class="col-12 pb-0 p-3 pt-0">
              <div class="form-group mb-0">
                <label for="myself" class="label">Myself</label>
                <textarea class="form-control" v-model="description" id="myself" rows="22" placeholder="You Can Write, Witch You Want About Yourself"></textarea>
              </div>
            </div>

            <div class="col-12 p-3">
              <div class="input-group">
                <button @click="submit" class="btn btn-success float-right">Save</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
</template>

<script>
	export default {
		Name:'AdminProfile',
		data(){
			return {
				formData 	  : new FormData(),
				url 		    : '',
				username 	  : '',
				name        : '',
				address     : '',
				description : '',
				mobile      : '',
				email       : '',
				facebook    : '',
				twitter     : '',
				linkedin    : '',
				youtube     : '',
				response    : [],
			}
		},
		mounted(){
			this.url = this.$store.state.site_url;
			axios.post(this.url+'/admin/profile/fetch')
			.then(response=>{
				let data          = response.data;
				this.name         = data.name;
        this.username     = data.username;
        this.address      = data.address;
        this.description  = data.description;
        this.mobile       = data.mobile;
        this.email        = data.email;
        this.facebook     = data.facebook;
        this.twitter      = data.twitter;
        this.linkedin     = data.linkedin;
        this.youtube      = data.youtube;
			})
			.then(err=>{err ? console.log(err) : ''});
		},
		methods:{
			image:function(event)
      {
				this.formData.append('photo', event.target.files[0]);
				this.http(this.formData);
			}, 
      
      submit:function()
      {
        this.http({
          name        : this.name,
          address     : this.address,
          description : this.description,
          mobile      : this.mobile,
          email       : this.email,
          facebook    : this.facebook,
          twitter     : this.twitter,
          linkedin    : this.linkedin,
          youtube     : this.youtube,
        });
      },

			http:function(data)
      {
				window.loader('on');
				axios.post(this.url+'/admin/profile/update', data)
				.then(response=>{
					this.response = response.data;
					window.loader('off');
				})
				.then(err=>{err ? console.log(err) : ''});
			}
		},
		computed:{
      profile_pic:function(){
        return this.$store.state.admin_photo;
      }
		},
		watch:{
			response:function(){
				for(const key in this.response){
					if(key == 'photo'){
						this.profile_pic = this.response.photo;
						this.$store.state.admin_photo = this.response.photo;
						window.success('Profile Picture Uploaded..');
					}
					else if(key == 'name'){
            this.$store.state.admin_name = this.response.name;
						window.success('Update Successful..');						
					}
				}
			}
		}
	}
</script>