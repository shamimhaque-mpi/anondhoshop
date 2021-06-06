<template>
	<div></div>
</template>

<script>
	export default {
		Name : 'Default',
		props:['site_url', 'admin_photo', 'admin_name', 'admin_type'],
		mounted(){
			this.$store.state.site_url   	= this.site_url;
			this.$store.state.admin_photo 	= this.admin_photo ? this.admin_photo : 'public/backend/icon/man.webp';
			this.$store.state.admin_name 	= this.admin_name;
			this.$store.state.admin_type 	= this.admin_type;
		} 
	}
</script>
