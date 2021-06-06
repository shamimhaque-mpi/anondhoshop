<template>
	<div class="popular-category container">
		<div class="row justify-content-center">
			<div class="col-12">
				<h3 class="category-page-title">Popular Categories</h3>
			</div>
			<div class="col-12 p-0">
				<div class="row">
					<div v-for="(value, key) in categories" class="card-category">
						<a :href="base_url+'shop/'+slug(value.id)" :title="value.name">
							<div class="position-relative category">
								<div class="cat-img" v-if="loaded">
									<img :src="base_url+value.image" :alt="value.name">
								</div>
								<h4 class="cat-title">{{ value.name }}</h4>
								<div class="box-loader" v-if="!loaded"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-12">
				<a href="#" class="cat-show-all"><span>View All</span></a>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name:'Category',
		data(){
			return {
				base_url 	: '',
				categories 	: 'pppppppppppppppppppp',
				loaded 		: false,
			}
		},
		mounted(){
			this.base_url = this.$store.state.base_url;
			if(this.$store.state.device == 'mobile'){
				this.categories="mmmmmmmmmmmm";
				this.category(0, 12);				
			}else{
				this.category();				
			}
		},
		methods:{
			category:function(start=0, end=20)
			{
				axios.post(this.base_url+'api/category', {start:start, end:end})
				.then(response=>{
					if(typeof(response) != 'undefined'){
						this.categories = response.data;
						this.loaded = true;
					}
				})
				.then(err=>(typeof(err) != 'undefined' ? console.log(err):''));
			},
			slug:function(id){
				let slug = {'category': id};
				return btoa(JSON.stringify(slug));
			}
		}
	}
</script>