@extends('backend.layouts.app')

@section('title', 'demo')

@section('content')

<div class="dashboard_header_wrapper mb-3">
    <h1 class="title">Deshboard</h1>
    <div class="clock">
        <h1>have a good day sir </h1>
        <div class="counter">
            @php(date_default_timezone_set("Asia/Dhaka"))
			<span class="counter_items" id="man_hour">{{ date("h") }}</span>
			<span class="counter_items" id="man_minute">{{ date("i") }}</span>
			<span class="counter_items" id="man_secounds">{{ date("s") }}</span>
			<span class="counter_items" id="man_am_pm">{{ date("a") }}</span>
		</div>
    </div>
</div>


<div class="dash_box_wrapper">

	<div class="dash_box">
		<div class="innerinfo_box bg-success">
			<div class="info_boxBody">
				<span>Category</span>
			</div>
			<div class="info_boxTitle">
				<span>1</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-secondary">
			<div class="info_boxBody">
				<span>Sub Category</span>
			</div>
			<div class="info_boxTitle">
				<span>5</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-info">
			<div class="info_boxBody">
				<span>Product</span>
			</div>
			<div class="info_boxTitle">
				<span>10</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-warning">
			<div class="info_boxBody">
				<span>Product</span>
			</div>
			<div class="info_boxTitle">
				<span>10</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-danger">
			<div class="info_boxBody">
				<span>Product</span>
			</div>
			<div class="info_boxTitle">
				<span>10</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-primary">
			<div class="info_boxBody">
				<span>Product</span>
			</div>
			<div class="info_boxTitle">
				<span>10</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-success">
			<div class="info_boxBody">
				<span>Product</span>
			</div>
			<div class="info_boxTitle">
				<span>10</span>
			</div>
		</div>
	</div>

	<div class="dash_box">
		<div class="innerinfo_box bg-secondary">
			<div class="info_boxBody">
				<span>Product</span>
			</div>
			<div class="info_boxTitle">
				<span>10</span>
			</div>
		</div>
	</div>

</div>
@endsection

@section('script')
<script>
    var interval_id = setInterval(function(){

    	let man_hour	= document.querySelector("#man_hour");
		let man_minute	= document.querySelector("#man_minute");
		let man_secounds= document.querySelector("#man_secounds");
		let man_am_pm	= document.querySelector("#man_am_pm");

		if(man_hour && man_minute && man_secounds && man_am_pm){
	        // work with man_secounds start---------------------------
	        // check man_secounds > 0
	        if(man_secounds.innerHTML>=0 && man_secounds.innerHTML<59){
	            let temp_sec = (+man_secounds.innerHTML+1);
	            man_secounds.innerHTML = (temp_sec>9) ? temp_sec : "0"+temp_sec;
	        }else{
	            man_secounds.innerHTML = "00";

	            // work with man_minute start---------------------------
	            // check man_minute > 0
	            if(man_minute.innerHTML>=0 && man_minute.innerHTML<59){
	                let temp_man_minute  = (+man_minute.innerHTML+1);
	                man_minute.innerHTML = (temp_man_minute>9) ? temp_man_minute : "0"+temp_man_minute;
	            }else{
	                man_minute.innerHTML = "00";
	            
	                // work with man_minute start---------------------------
	                if(man_hour.innerHTML>0 && man_hour.innerHTML<12){
	                    let temp_man_hour = (+man_hour.innerHTML+1);
	                    man_hour.innerHTML = (temp_man_hour>9) ? temp_man_hour : "0"+temp_man_hour;;
	                }else{
	                    man_hour.innerHTML = "01";
	                    if(man_am_pm){
	                        man_am_pm.innerHTML = (man_am_pm.innerHTML=='am') ? "pm" : "am";
	                    }
	                }
	            }
	        }
        }
    }, 1000);
</script>
@endsection