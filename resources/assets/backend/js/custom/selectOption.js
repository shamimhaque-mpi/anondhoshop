// Ambade Vue
import Vue from 'vue';
class SelectOption {
	constructor() {
		console.log('Select Option: v-1.0');
		SelectOption.setSelectField();
		Vue.prototype.$selectOption = SelectOption.option();
	}

	//Append Select field
	static setSelectField() {
		window.addEventListener('load', ()=>{
			let option_field = document.querySelectorAll('.select2');
			option_field = Array.isArray(option_field) ? option_field : Object.values(option_field);
			//Each
			option_field.forEach((value, key)=>{
				let options_text  		= [];
				let options_value  		= [];
				let attributes 			= [];
				let parent 				= value.parentElement;
				let disable_field_key	= [];
				let selected_field_key	= [];

				if(value.hasAttribute('name')){
					attributes['name'] = value.getAttribute('name');
				}
				if(value.hasAttribute('class')){
					attributes['class'] = value.getAttribute('class').replace('select2', '');
				}
				if(value.hasAttribute('id')){
					attributes['id'] = value.getAttribute('id');
				}
				if(value.hasAttribute('required')){
					attributes['required'] = value.getAttribute('required');
				}
				// Get Select Childs
				let selecte_childs = value.children;
				selecte_childs = Array.isArray(selecte_childs) ? selecte_childs : Object.values(selecte_childs);

				// Fetch All options and store value and text
				selecte_childs.forEach((selecte_child,child_key)=>{
					options_text[child_key] = selecte_child.innerHTML;
					options_value[child_key] = 	selecte_child.getAttribute('value');
					if(selecte_child.hasAttribute('disabled')){
						disable_field_key.push(child_key);
					}
					if(selecte_child.hasAttribute('selected')){
						selected_field_key.push(child_key);
					}
				});

				value.remove();
				// Append sigle Select option box
				SelectOption.appenContent(attributes, parent, options_text, options_value, disable_field_key, selected_field_key);
			});		

			// Check Click Event and open	
			SelectOption.clickEvent();
			// Close When Out Side Click
			SelectOption.closeWhenOutSideClick();
		});
	}

	// Append Select box
	static appenContent(attributes, parent, options_text, options_value, disable_field_key, selected_field_key) {
		let fetchOption = SelectOption.fetchOption(options_text, options_value, disable_field_key, selected_field_key);
		let div = document.createElement('div');
		let content = `
			<div class="v-search-option ${ attributes['class'] }">
				<div class="selected-data">
					<span class="v-data">${ fetchOption['selected_text'] }</span>
					<input type="text" ${ attributes['id'] ? "id='"+attributes['id']+"'":'' } name="${ attributes['name'] }" value="${ fetchOption['selected_value'] }" class="v-main-value"${ attributes['required'] ? "required":'' }>
				</div>
				<div class="arrow"></div>
				<div class="options">
					<div class="search-field">
						<input type="text" class="sear-input" placeholder="Search Your Key...">
					</div>
					<div class="option-group">
						${ fetchOption['option_content'] }
					</div>
				</div>
			</div>
		`;
		div.innerHTML = content;
		parent.append(div);
	}

	// Click Event
	static clickEvent() {
		let option_box 		= document.querySelectorAll('.v-search-option');
		let options 		= document.querySelectorAll('.options');
		let sear_input 		= document.querySelectorAll('.sear-input');
		let option_group 	= document.querySelectorAll('.option-group');
		let v_data 			= document.querySelectorAll('.v-data');
		let v_main_value 	= document.querySelectorAll('.v-main-value');

			option_group 	= Array.isArray(option_group) ? option_group : Object.values(option_group);
			option_box 		= Array.isArray(option_box) ? option_box : Object.values(option_box);
			options 		= Array.isArray(options) ? options : Object.values(options);
			sear_input 		= Array.isArray(sear_input) ? sear_input : Object.values(sear_input);
			v_data 			= Array.isArray(v_data) ? v_data : Object.values(v_data);
			v_main_value 	= Array.isArray(v_main_value) ? v_main_value : Object.values(v_main_value);

		if(option_box && options) {
			option_box.forEach((value, key)=>{
				value.children[0].addEventListener('click', ()=>{
					options[key].classList.add('show');
					sear_input[key].focus();
					options.forEach((value_second, key_second)=>{
						if(key != key_second && value_second.classList.contains('show')) {
							value_second.classList.remove('show');
						}
					});
				});
			});

			// Searching key
			SelectOption.searching(sear_input, option_group);
			// Click And Push Event
			SelectOption.optionClick(option_group, v_data, v_main_value);
		}
	}

	// Close When Out Side Click
	static closeWhenOutSideClick() {
		window.addEventListener('click', (event)=>{
			if(!event.target.closest('.v-search-option')) {
				let options 	= document.querySelectorAll('.options');
					options 	= Array.isArray(options) ? options : Object.values(options);

				options.forEach((value)=>{
					if(value.classList.contains('show')){
						value.classList.remove('show')
					}
				});
			}
		});
	}

	// Fetch Options
	static fetchOption(options_text, options_value, disable_field_key, selected_field_key) {
		let option_content = '';
		let selected_text  = '';
		let selected_value = '';

		options_text.forEach((value, key)=>{
			let attributes = '';
			let class_attr = '';
			if(selected_field_key.indexOf(key) > -1) {
				attributes 		+= 'data-selected="true" ';
				selected_text 	+= value
			}
			if(disable_field_key.indexOf(key) > -1) {
				attributes += 'data-disabled="true"';
				class_attr = 'disabled';
			}
			option_content += `<div class="option ${ class_attr }" data-value="${ options_value[key] }" ${ attributes }>${ value }</div>`;
		});
		if(selected_text == '') {
			selected_text  = options_text[0];
			selected_value = options_value[0];
		}

		let return_value				= [];
		return_value['option_content']	= option_content;
		return_value['selected_text'] 	= selected_text;
		return_value['selected_value'] 	= selected_value;

		return return_value;
	}

	// Searching key
	static searching(sear_input, option_group) {

		sear_input.forEach((value, key)=>{
			value.addEventListener('input', ()=>{
				let options_childs = option_group[key].children;

				options_childs = Array.isArray(options_childs) ? options_childs : Object.values(options_childs);

				let searching_text = new RegExp(value.value, 'i');

				options_childs.forEach((sigle_child, key)=>{
					let text = sigle_child.innerText
					if(text.search(searching_text) > -1) {
						if(value.value != '') {
							sigle_child.style.display = '';
						}
						else {
							options_childs.forEach((sigle_child_tag)=>{
								sigle_child_tag.style.display = '';
							});
						}
					}
					else if(value.value != '') {
						sigle_child.style.display = 'none';						
					}
				});
			});
		});
	}

	// Click And Push Event
	static optionClick(option_group, v_data, v_main_value) {
		option_group.forEach((value, key)=>{
			let options = value.children;
			options 	= Array.isArray(options) ? options : Object.values(options);

			options.forEach((option, key_op)=>{
				if(!option.dataset.disabled) {
					option.addEventListener('click', ()=>{
						v_data[key].innerHTML 	= option.innerHTML;
						v_main_value[key].value = option.dataset.value;
						v_main_value[key].click();
						option_group[key].parentElement.classList.remove('show');
					});
				}
			});
		});
	}

	// Get Option value
	static option() {
		let methods = {
			value:(id, value='')=>{
				if(value != ''){
					// Main value On change
					SelectOption.onchange(id, value); 
				}
				return document.querySelector('#'+id).value;
			},
			newOption:(id, name, value)=>{
				SelectOption.newOption(id, name, value);
			},
			clearOption:(id)=>{
				SelectOption.clearOption(id);
			}
		};
		return methods;
	}

	// Click And Push Event
	static onchange(id, value) {
		let input 			= document.querySelector('#'+id);
		if(input && input.parentElement.nextElementSibling.nextElementSibling.children){
			let option 		= input.parentElement.nextElementSibling.nextElementSibling.children[1].children;
			option 			= Array.isArray(option) ? option : Object.values(option);
			let condition 	= true;

			option.forEach((sigle_option, key)=>{
				if(sigle_option.dataset.value == value) {
					sigle_option.click();
					condition = false;
				}
			});
			if(condition) {
				input.parentElement.children[0].innerHTML = option[0].innerHTML;
				input.value = option[0].dataset.value;
			}
		}
	}

	// New Option 
	static newOption(id, name, value) 
	{
		let tag 				= document.querySelector('#'+id);
		if(tag && tag.parentElement.nextElementSibling.nextElementSibling.children){
			let option_group 	= tag.parentElement.nextElementSibling.nextElementSibling.children[1];

			let new_option 		= document.createElement('div');
			
			new_option.innerText= name;
			new_option.setAttribute('class', 'option');
			new_option.setAttribute('data-value', value);

			option_group.append(new_option);
			SelectOption.clickEvent();
		}
		return true;
	}

	// Clear Option 
	static clearOption(id) 
	{
		let tag 				= document.querySelector('#'+id);
		if(tag && tag.parentElement.nextElementSibling != null){
			let option_group 	= tag.parentElement.nextElementSibling.nextElementSibling.children[1];
			let options 		= option_group.children;
			let disabled_option	= false;

			options 			= Array.isArray(options) ? options : Object.values(options);
			options.forEach((option)=>{
				if(option.classList.contains('disabled')){
					tag.parentElement.firstElementChild.innerHTML = option.innerHTML;
					tag.parentElement.lastElementChild.value = '';
					disabled_option = `<div class="option disabled" data-value="" data-disabled="true">${ option.innerHTML }</div>`;
				}
			});

			if(disabled_option){
				option_group.innerHTML = disabled_option;
			}else{
				option_group.innerHTML = '';
			}
			
			SelectOption.clickEvent();
		}
		return true;
		
	}
}
export const selectOption = new SelectOption();