<template>
	<div class="search-bar align-self-center" id="search_field">
		<input type="search" ref="search_field" class="search-field" :placeholder="slide" v-model="query">
		<span class="search-icon">
			<img :src="base_url+'public/frontend/icon/search.svg'">
		</span>
		<div class="search-items" v-if="is_visible && query">
			<ul>
				<li>
					<span class="total-found" v-if="is_loading">
						Loading....
					</span>
					<span class="total-found" v-if="!is_loading">
						<span v-if="total_items==0">Nothings Found, Please Try Again With Another Keywords...</span>
						<span v-else >Total {{total_items}} Items Found In {{queryTime}}s</span>
							
					</span>
				</li>

				<li v-for="item in items" v-if="items && items.length>0"> 
					<a href="#">
						<div class="search-item">
							<img :src="base_url+item.img">
							<div class="item-info">
								<h4>{{item.name}}</h4>
								<p>🏷 {{item.cat_name}}</p>
							</div>
						</div>
					</a>
				</li>

				<li v-if="items && items.length>0">
					<a href="#" class="read-more">See More >></a>
				</li>
			</ul>

		</div>
	</div>
</template>

<script>
	export default {
		name: 'Search',
		data(){
			return {
				slide 		: '',
				query 		: '',
				items 		: [],
				base_url 	: '',
				queryTime 	: 0,
				is_loading  : true,
				is_visible  : false,
				total_items : 0,
				placeholder : 'Search Your Favourite Products',
			}
		},
		mounted(){
			this.query 	  = this.$store.state.search_keywords;
			this.base_url = this.$store.state.base_url;
			this.slideStart();
			this.searchQuery();
		},
		methods:{
			slideStart:function(){
				let str_len  = (this.placeholder).length;
				let index 	 = 0;
				let speed 	 = 200;
				let vueObj 	 = this;
				let terning  = 'front';
				let step_one = '';
				let break_time_count = 0;

				function slide(){
					step_one = setInterval(()=>{
						if(terning=='front'){ index++; }else{ index--; }

						if(str_len == index){
							terning = 'beside';
							speed 	= 50;
							timeout();
						}
						else if(index==0){
							terning = 'front';
							speed 	= 200;
							timeout();
						}
						vueObj.slide = (vueObj.placeholder).slice(0, index)+'|';
					}, speed);
				}

				function timeout(){
					clearInterval(step_one);
					let break_time = setInterval(()=>{
						break_time_count++;
						if(break_time_count == 6){
							clearInterval(break_time);
							break_time_count=0;
							slide();
						}
						if( break_time_count%2!=0){
							vueObj.slide = (vueObj.slide).slice(0, (vueObj.slide).length-1);
						}else{
							vueObj.slide = vueObj.slide+'|';
						}
					}, 500);
				}
				slide();
			},
			searchQuery:function(){
				let search_field = this.$refs.search_field;
				let vueObj 		 = this;
				let timeCount    = 0;
				let timeout      = '';
				// Start Searching Time
				function startTiming(){
					timeout = setTimeout(()=>{
						vueObj.search();
					}, 600);
				}
				// Reset Keyword Searchning Time
				search_field.addEventListener('input', ()=>{
					clearTimeout(timeout);
					startTiming();
				});
				// Check Here User Focus And Active Search
				window.addEventListener('click', (event)=>{
					if(event.target.closest('.search-bar')){
						vueObj.is_visible = true;
					}else{
						vueObj.is_visible = false;
					}
				});

			},
			search:function(){
				let start = Date.now();
				this.is_loading = true;
				axios.post(this.base_url+'shop/search', {key:this.query}).
				then(response=>{
					if(response.data){
						this.items 		 = (response.data).items;
						this.total_items = (response.data).total;
						this.queryTime = parseFloat((Date.now() - start) / 1000).toFixed(2);
					}
					else{
						this.items = {};
					}
					this.is_loading = false;
				}).
				then(err=>console.log(err));
			}
		},
		watch:{
			query:function(){
				this.is_loading = true;
				if(this.query==''){
					this.items = {};
				}
			}
		}
	}
</script>