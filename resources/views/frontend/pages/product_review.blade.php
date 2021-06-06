@extends('frontend.layouts.app')

@section('title', 'Product Review')

@section('content')
	<div class="container">
		<div class="main-wrapper mt-3">
			<div class="row">
				<!-- gellary -->
				<div class="gellary p-0">
					<div class="img-wrapper">
						<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
					</div>
					<div class="others-pic">
						<span class="previous"></span>
						<div class="thumnil">
							<div class="img"> 
								<input type="radio" name="avata" value="">
								<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
							</div>
							<div class="img"> 
								<input type="radio" name="avata" value="">
								<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
							</div>
							<div class="img"> 
								<input type="radio" name="avata" value="">
								<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
							</div>
							<div class="img"> 
								<input type="radio" name="avata" value="">
								<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
							</div>
							<div class="img"> 
								<input type="radio" name="avata" value="">
								<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
							</div>
							<div class="img"> 
								<input type="radio" name="avata" value="">
								<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
							</div>
						</div>
						<span class="next"></span>
					</div>
				</div>
				<!-- Product information -->
				<div class="product-info">
					<div class="basic-info-cart">
						<div class="some-info">
							<h2>Stylish Beautiful New Design Wall Clock</h2>
							<ul>
								<li>
									<a href="#">Avarage Ratings <span>4/5</span> </a> | 
									<a href="#">219 Answered Questions</a>
								</li>
								<li>
									<a href="#">Brand : No Brand</a> | 
									<a href="#">Category : No Category</a>
								</li>
							</ul>	
							<hr>
							<div>
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
								The quick brown fox jumps over the lazy dog.
							</div>						
						</div>



						<div class="quick-action">
							<div class="action-wrapper">
								<div class="price-rating">
									<h4 class="price">
										<span>DBT&nbsp;</span>21.12
										<small class="previous-price"><sub>(<del>৳22.00</del>)</sub></small>
									</h4>
								</div> 

								<div class="rating">
									<span></span>
								</div>

								<div class="color-size">
									<table>
										<tr>
											<td>Color&nbsp;</td> 
											<td>
												<label><input type="radio" name="color" value="2">&nbsp;Red</label>
												<label><input type="radio" name="color" value="1">&nbsp;Black</label>
											</td>
										</tr> 
										<tr>
											<td>Sizes</td> 
											<td>
												<div class="size-family">
													<div class="size">
														<input type="radio" name="size" value="2"> 
														<span>M</span>
													</div>
													<div class="size">
														<input type="radio" name="size" value="1"> 
														<span>L</span>
													</div>
												</div>
											</td>
										</tr>
									</table>
								</div> 
								<div class="cart-wishlist">
									<div class="h100">
										<div class="add-to-cart">
											<button>Add To Cart</button>
										</div>
									</div> 
									<div class="add-to-wishlist">
										<button>Add To Wishlist</button>
									</div>
								</div>
							</div>
							<small class="rating mt-3">Avarage Rating 4/5 - Number of review: 20 <a href="#comments" class="link">View All</a></small> 

						</div>
					</div>
				</div>
				<!-- Shop-information -->
				<div class="other-info p-0">
					<div class="product-infos">
						<div class="info-item">
							<h5>Brand</h5> 
							<span>Nokia</span>
						</div> 
						<div class="info-item">
							<h5>Services</h5> 
							<span>Free Shipping</span>
						</div> 
						<div class="info-item">
							<h5>Services Type</h5> 
							<span>Local Seller</span>
						</div> 
						<div class="info-item">
							<h5>Warranty Period</h5> 
							<span>2 Year</span>
						</div>
					</div>
				</div>
				<!-- End Shop information wrapper -->
			</div>

			<hr/>

			<div class="row mt-3">
				<div class="col-12 p-0 mb-2 bg-secondary">
					<div class="row">
						<div class="col-4 p-0">
							<div class="shop">
								<div class="logo">
									<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
								</div>
								<div class="shop-info">
									<h4>Rock35</h4>
									<p><a href="#">350 Products is Available</a></p>
								</div>
							</div>
						</div>
						<div class="col-4 p-0 shop">
							
						</div>
					</div>
				</div>

				<div class="col-9">
					<div class="details">
<pre>
The quick brown fox jump over the lazy dog.
	1. First Charging
	2. Lag less
	3. 2.5GHz Processor
	4. Brotcost Service
	5. 7 Core
The quick brown fox jump over the lazy dog.
	1. First Charging
	2. Lag less
	3. 2.5GHz Processor
	4. Brotcost Service
	5. 7 Core
The quick brown fox jump over the lazy dog.
	1. First Charging
	2. Lag less
	3. 2.5GHz Processor
	4. Brotcost Service
	5. 7 Core
The quick brown fox jump over the lazy dog.
	1. First Charging
	2. Lag less
	3. 2.5GHz Processor
	4. Brotcost Service
	5. 7 Core
The quick brown fox jump over the lazy dog.
	1. First Charging
	2. Lag less
	3. 2.5GHz Processor
	4. Brotcost Service
	5. 7 Core
The quick brown fox jump over the lazy dog.
</pre>
					</div>
				</div>
				<div class="col-3 p-0">
					<div class="suggested-product">
						<div class="col-12">
							<a href="#">
								<div class="s-product">
									<div class="sp-image">
										<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
									</div>
									<div class="sp-info">
										<h4>Rock35</h4>
										<p class="price">DBT 500 <small class="previous-price">(-20%)</small></p>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="view-img">
						<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
					</div>
				</div>
				<div class="col-6">
					<div class="view-img">
						<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
					</div>
				</div>
				<div class="col-6">
					<div class="view-img">
						<img src="{{asset('public/images/product/medium/1604928609.webp')}}">
					</div>
				</div>
			</div>

			<!-- 
				Comment Section 
			-->
			<hr id="comments">
			<div class="row">
				<div class="col-8">
					<div class="comments">
						<p>#56 Review of this Product...</p>
						<div>
							<div class="profile">
								<div class="img">
									<img src="http://localhost/anondhoshop/public/images/user/1606327018.webp">
								</div>
								<div>
									<h4>Md. Shamim Haque</h4>
								</div>
							</div>
							<div class="comment">
								<p>Lorem ipsume Lorem ipsume Lorem ipsume Lorem ipsumeLorem ipsumeLoremLorem ipsume </p>
							</div>
						</div>
						<div>
							<div class="profile">
								<div class="img">
									<img src="http://localhost/anondhoshop/public/images/user/1606327018.webp">
								</div>
								<div>
									<h4>Md. Shamim Haque</h4>
								</div>
							</div>
							<div class="comment">
								<p>Lorem ipsume Lorem ipsume Lorem ipsume Lorem ipsumeLorem ipsumeLoremLorem ipsume </p>
							</div>
						</div>
						<div>
							<div class="profile">
								<div class="img">
									<img src="http://localhost/anondhoshop/public/images/user/1606327018.webp">
								</div>
								<div>
									<h4>Md. Shamim Haque</h4>
								</div>
							</div>
							<div class="comment">
								<p>Lorem ipsume Lorem ipsume Lorem ipsume Lorem ipsumeLorem ipsumeLoremLorem ipsume </p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-4">
					<form action="" method="POST" enctype="multipart/form-data">
						<div class="profile">
							<div class="img">
								<img src="http://localhost/anondhoshop/public/images/user/1606327018.webp">
							</div>
							<div>
								<h4>Md. Shamim Haque</h4>
								<span class="username">@shamimhaque57</span>
							</div>
						</div>
						<div class="form-group">
							<label>Explaination</label>
							<textarea class="form-control" rows="10" placeholder="Write Your Review..."></textarea>
						</div>
						<div class="form-group">
							<label>Photos</label>
							<input type="file" name="" class="form-control">
						</div>
						<div>
							<button class="btn btn-success float-right">Submit</button>
						</div> 
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/product_details.css') }}">
<style>
	hr {
	    margin: 8px 0px;
	    border: 1px solid #efefef;
	}
	.basic-info-cart {
		padding: 15px;

	}
	.some-info {
	    padding: 17px 0px;
	}
	.some-info h2 {
	    color: var(--font);
	    font-weight: 500;
	    font-size: 34px;
	}
	.some-info ul {
	    list-style: none;
	    margin-top: 10px;
	    font-size: 17px;
	}
	.gellary {
		width: 26%;
	}
	.product-info {
		width: 54%;
	}
	.other-info {
		width: 20%;
	}
	.details {
		padding-left: 12px;
	}
	.shop-wrapper {
	    background: #eff0f5;
	}
	.shop {
	    display: flex;
	    align-items: center;
	    padding: 5px;
	}
	.shop .logo {
	    height: 70px;
	    width: 70px;
	    overflow: hidden;
	}
	.shop .logo img{
		width: 100%;
		left: 100%;
		object-fit: cover;
	}
	.shop-info {
	    padding-left: 10px;
	    font-weight: 100;
	    color: var(--font);
	}
	.shop-info p {
		font-size: 16px;
	}
	.shop-info p:hover {
		text-decoration: underline;
		color: blue;
	}
	.suggested-product > .col-12{
		padding: 0;
	}
	.s-product {
		display: flex;
	    align-items: center;
	    background: #eff0f5;
	    padding: 5px;
	}
	.s-product .sp-image {
	    height: 75px;
	    width: 75px;
	    overflow: hidden;
	}
	.s-product .sp-image img{
		width: 100%;
		left: 100%;
		object-fit: cover;
	}
	.s-product .sp-info {
		padding-left: 10px;
	    font-weight: 100;
	    color: var(--font);
	}
	.sp-info .price {
	    color: red;
	    margin-top: 0px;
	    font-size: 20px;
	    line-height: 20px;
	}
	.view-img {
		width: 100%;
		overflow: hidden;
	}
	.view-img img {
		width: 100%;
	}
	.profile {
	    display: flex;
	    align-items: center;
	    margin-top: 10px;
	    margin-bottom: 10px;
	    background: var(--secondary);
	    padding: 15px;
	}
.profile .img {
    height: 60px;
    width: 60px;
    border-radius: 50%;
    border: 1px solid #ddd;
    margin-right: 10px;
    overflow: hidden;
}
.profile .img img{
	width: 100%;
	left: 100%;
	object-fit: cover;
}
.profile h4 {
    font-weight: 100;
    font-size: 21px;
}
.profile .username {
    font-weight: 100;
    font-size: 18px;
}
.comments .profile {
	background: none;
	margin-bottom: 0;
	padding-bottom: 7px;
}
.comments .profile .img {
    height: 40px;
    width: 40px;
}
.comments .profile h4 {
    font-size: 18px;
}
.comment {
    max-width: 500px;
    margin-left: 10px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    padding: 10px;
    position: relative;
}
.comment::before {
    content: '';
    width: 12px;
    height: 12px;
    border: 1px solid #ddd;
    position: absolute;
    top: -7px;
    left: 18px;
    transform: rotate(45deg);
    background: #f9f9f9;
    z-index: 0;
    border-right: none;
    border-bottom: none;
}
</style>
@endsection