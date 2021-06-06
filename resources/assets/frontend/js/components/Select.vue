<template>
	<div class="select-option" :class="cls?cls:''">
		<div class="search-field" ref="search_field">
			<div class="selected-options" ref="option_wrapper">
				<span v-for="(row, key) in keyword" :class="!is_multiple ? 'sigle-select':''" v-if="(!is_multiple ? (key==0) : true)">{{row.text}} <button @click="remove(row.key, $event.target)" class="slt-close">&times;</button></span>
			</div>
			<input type="text" name="v-search" ref="input" :placeholder="placeholder ? placeholder :' |Search Your keyword...'">
			<div class="arrow"></div>			
		</div>
		<div class="option-group">
			<div class="selected-options">
				<span v-for="(row, key) in keyword" :class="!is_multiple ? 'sigle-select':''" v-if="(!is_multiple ? (key==0) : true)">{{row.text}} <button @click="remove(row.key, $event.target)" class="slt-close">&times;</button></span>
			</div>
			<div ref="options">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props:['value', 'watch', 'multiple', 'placeholder', 'cls'],
		name:'Select',
		data(){
			return {
				is_multiple  : false,
				flt_value 	 : '',
				selected_key : [],
				keyword 	 : [],
				parent 		 : '',
				is_option	 : false,
				is_rendered  : false,
			}
		},
		mounted(){
			if(this.multiple==true){
				this.is_multiple = true;
			}
			this.flt_value = this.value;
			this.checking();
			this.windowWatching();
		},
		methods:{
			checking:function(){
				setTimeout(()=>{
					// Filtering Value whitch is from form parent
					if(typeof this.value == 'object'){
						this.flt_value = (this.value).filter(x=>{
							return (isNaN(+x) ? x : +x);
						});
					}
					else{ this.flt_value = (isNaN(+this.value) ? this.value : (this.value!='' ? +this.value : '')); }

					let all_options = this.$refs.options.children;
					let vueObj 		= this;
					this.searching(all_options, vueObj);

					if(all_options){
						Object.values(all_options).forEach((sigle_tag, key)=>{
							let op_value = sigle_tag.dataset.value;
							if(vueObj.is_multiple && this.is_multiple && op_value){
								if((vueObj.flt_value).indexOf((isNaN(+op_value) ? op_value : +op_value))>-1){
									vueObj.selected_key.push(key);
									sigle_tag.classList.add('active');
								}
							}
							else if(!vueObj.is_multiple && !this.is_multiple && op_value){
								if(vueObj.flt_value == (isNaN(+op_value) ? op_value : +op_value)){
									sigle_tag.classList.add('active');
									vueObj.selected_key.push(key);
								}else{
									sigle_tag.classList.remove('active');
									let selected_key = [];
									(vueObj.selected_key).filter(x=>{
										if(x!=key){
											selected_key.push(x);
										}
									});
									vueObj.selected_key = selected_key;
								}
							}

							// Handle The Click Event Of Option Field
							sigle_tag.addEventListener('click', ()=>{
								if(sigle_tag.classList.contains('active') && this.is_multiple){
									sigle_tag.classList.remove('active');

									let selected_key = [];
									(vueObj.selected_key).filter((x)=>{
										if(x!=key){
											selected_key.push(x);
										}
									});

									vueObj.selected_key = selected_key;

									vueObj.flt_value = (vueObj.flt_value).filter(x=>{
										if(x!=(isNaN(+sigle_tag.dataset.value) ? sigle_tag.dataset.value : +sigle_tag.dataset.value)){
											return x;
										}
									});
								}
								else if(this.is_multiple){
									sigle_tag.classList.add('active');
									vueObj.flt_value.push(isNaN(+sigle_tag.dataset.value) ? sigle_tag.dataset.value : +sigle_tag.dataset.value);
									vueObj.selected_key.push(key);
								}
								else{
									let c_active = sigle_tag.parentElement.querySelector('.active');
									if(c_active){
										c_active.classList.remove('active');
									}
									sigle_tag.classList.add('active');
									vueObj.selected_key = [key];
									vueObj.flt_value 	= isNaN(+sigle_tag.dataset.value) ? sigle_tag.dataset.value : +sigle_tag.dataset.value;	
								}
							});

						});
					}
				}, 1);
			},
			searching:function(all_options, vueObj){
				let input = vueObj.$refs.input;
				input.addEventListener('input', ()=>{
					Object.values(all_options).map(x=>{
						if((x.innerText.toLowerCase()).indexOf(input.value.toLowerCase()) > -1)
							x.classList.remove('d-none');
						else
							x.classList.add('d-none');
					});
				});
			}, 
			adjusting:function(){
				// setTimeout(()=>{
				// 	let readasmargin = this.$refs.option_wrapper;
				// 	let options = this.$refs.options;
				// 	if(readasmargin && this.is_option){
				// 		options.style.marginTop = readasmargin.scrollHeight+'px';
				// 	}
				// 	else{
				// 		options.removeAttribute('style');
				// 	}				
				// }, 100);
			},
			remove:function(key, tag){
				this.parent = tag.closest('.select-option');
				let group 	= this.$refs.options;
				let option  = Object.values(group.children)[key];

				if(this.is_multiple){
					if(option){
						this.flt_value = (this.flt_value).filter(x=>{
							if(x!=(isNaN(+option.dataset.value) ? option.dataset.value : +option.dataset.value)){
								return x;
							}
						});
						option.classList.remove('active');
					}
					let selected_key = [];
					(this.selected_key).filter(x=>{
						if(x!=key){
							selected_key.push(x);
							return x;
						}
					});
					this.selected_key = selected_key;

				}
				else if(option){
					option.classList.remove('active');
					this.selected_key = [];
					this.flt_value = '';
				}

				setTimeout(()=>{
					(this.parent).querySelector('.option-group').classList.add('open');
					(this.parent).querySelector('.search-field').classList.add('focus');
					this.is_option = true;
				},1);
			},
			windowWatching:function(){
				let vueObj = this;
				let group  = vueObj.$refs.options;
				let search_field = vueObj.$refs.search_field;
				window.addEventListener('click', (event)=>{
					vueObj.is_option = false;
					group.closest('.select-option').querySelector('.option-group').classList.remove('open');
					search_field.classList.remove('focus');

					if(event.target.closest('.select-option') && !event.target.classList.contains('option-field')){
						event.target.closest('.select-option').querySelector('.option-group').classList.add('open');
						event.target.closest('.select-option').querySelector('.search-field').classList.add('focus');
						vueObj.is_option = true;
					}

				});
			},
			pushKeyWord:function(){
				setTimeout(()=>{
					let keyword = [];
					let options = Object.values(this.$refs.options.children);
					(this.selected_key).forEach((s_key)=>{
						keyword.push({key:s_key, text:options[s_key].innerText, value:options[s_key].dataset.value});
					});
					this.keyword = keyword;
					this.adjusting();
				},1);
			}
		},
		watch:{
			selected_key:function(){
				this.pushKeyWord();
			},
			flt_value:function(){
				this.$emit('update:value', this.flt_value);
			},
			is_option:function(){
				this.adjusting();
			},
			watch:function(){
				this.selected_key = [];
				this.checking();
				this.pushKeyWord();
			},
			value:function(){
				if(!this.is_rendered){
					this.checking();
				}
			}
		}
	}
</script>
<style scoped>
	.selected-options span {
		background: #f3f3f3;
	}
</style>