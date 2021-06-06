<template>
	<div :class="'option-field '+active" :data-value="value">
		<slot></slot>
	</div>
</template>

<script>
	export default {
		props:['value'],
		name:'Option',
		data(){
			return {
				active: '',
			}
		},
		mounted(){
			
		}
	}
</script>