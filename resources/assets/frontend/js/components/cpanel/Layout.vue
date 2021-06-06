<template>
	<div class="user-panel">
		<user-menu
			:name="name"
			type="panel"
		></user-menu>
		<div class="user-panel-body">
			<home v-if="state=='home'"></home>
			<my_order v-if="state=='user/my_order'"></my_order>
			<wishlist v-if="state=='user/wishlist'"></wishlist>
			<settings v-if="state=='user/settings'"></settings>
		</div>
	</div>
</template>

<script>
	import home 	from './pages/home';
	import my_order from './pages/my_order';
	import wishlist from './pages/wishlist';
	import settings from './pages/settings';

	export default {
		name : 'Layout',
		components:{
			'home' 	   : home,
			'my_order' : my_order,
			'wishlist' : wishlist,
			'settings' : settings,
		},
		props:{
			name : [String],
		},
		data(){
			return {

			}
		},
		mounted(){
			//console.log(this.is_home);
		},
		methods:{

		},
		computed:{
			state:function(){
				return this.$store.state.uri;
			}
		}
	}
</script>