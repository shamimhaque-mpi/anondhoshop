@if(session()->has('success'))
<script>
	window.addEventListener('load', ()=>{
		window.success("{{ session()->get('success') }}");		
	})
</script>
@endif

@if(session()->has('warning'))
<script>
	window.addEventListener('load', ()=>{
		window.warning("{{ session()->get('warning') }}");
	})
</script>
@endif