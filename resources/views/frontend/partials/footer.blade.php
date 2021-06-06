<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-3">
				<div class="footer-logo">
					<img src="{{ asset(SiteInfo()->logo) }}">
				</div>
				<div class="about-us">
					<p>
						{{ SiteInfo()->description }}
						<a href="{{route('about_us')}}">Read More</a>
					</p>
				</div>
				<div class="social-links">
					<ul>
						<li>
							<a href="#" title="Facebook">
								<span class="social-icon-svg">
									<svg viewBox="0 0 100 100" xml:space="preserve">
										<path class="social-icon-fill" style="fill:#3FF1FF;" d="M61.74,29.33H69v-9.82C67.68,19.26,63.39,19,58.44,19c-10.56,0-17.49,5.17-17.49,14.47v8.78H29.4v11.11h11.55 V81h14.19V53.36h10.89l1.65-11.11H54.81v-7.49C54.81,31.4,56.13,29.33,61.74,29.33z"/>
									</svg>
								</span>
							</a>
						</li>
						<li>
							<a href="#" title="twitter">
								<span class="social-icon-svg">
								<svg viewBox="0 0 100 100" xml:space="preserve">
										<path class="social-icon-fill" style="fill:#D8FFBF;" d="M38.9,74c23.18,0,35.85-18.67,35.85-34.85c0-0.53-0.01-1.06-0.04-1.58c2.46-1.73,4.6-3.89,6.29-6.34 c-2.26,0.98-4.69,1.63-7.24,1.93c2.6-1.52,4.6-3.92,5.54-6.78c-2.43,1.4-5.13,2.42-8,2.97c-2.3-2.38-5.57-3.87-9.2-3.87 c-6.96,0-12.6,5.49-12.6,12.25c0,0.96,0.11,1.9,0.33,2.79c-10.47-0.51-19.76-5.39-25.97-12.8c-1.08,1.81-1.71,3.91-1.71,6.16 c0,4.25,2.22,8,5.61,10.2c-2.07-0.06-4.01-0.61-5.71-1.53c0,0.05,0,0.1,0,0.16c0,5.93,4.34,10.89,10.11,12.01 c-1.06,0.28-2.17,0.43-3.32,0.43c-0.81,0-1.6-0.08-2.37-0.22c1.6,4.87,6.26,8.41,11.77,8.51c-4.31,3.29-9.75,5.24-15.65,5.24 c-1.02,0-2.02-0.06-3.01-0.17C25.16,71.97,31.78,74,38.9,74"/>
									</svg>
								</span>	
							</a>
						</li>
						<li>
							<a href="#" title="Linkeding">
								<span class="social-icon-svg">
									<svg viewBox="0 0 100 100" xml:space="preserve"> 
										<g>
											<rect class="social-icon-fill" x="24" y="41" style="fill:#35FFF6;" width="11.63" height="33"/>
											<path class="social-icon-fill" style="fill:#35FFF6;" d="M67.3,41.39c-0.12-0.04-0.24-0.08-0.37-0.11c-0.16-0.03-0.31-0.06-0.47-0.08C65.84,41.08,65.17,41,64.37,41 l0,0l0,0c-6.78,0-11.08,4.55-12.5,6.31V41H40.25v33h11.63V56c0,0,8.79-11.3,12.5-3c0,7.41,0,21,0,21H76V51.73 C76,46.74,72.3,42.59,67.3,41.39z"/>
											<ellipse class="social-icon-fill" style="fill:#35FFF6;" cx="29.69" cy="31.25" rx="5.69" ry="5.25"/>
										</g>
									</svg>
								</span>
							</a>
						</li>
						<li>
							<a href="#" title="Youtube">
								<span class="social-icon-svg">
									<svg viewBox="0 0 100 100" xml:space="preserve">
										<path class="social-icon-fill" d="M78.67,36.29l0.08,0.43c-0.73-2.24-2.68-3.97-5.17-4.6l-0.05-0.01C68.85,31,50.02,31,50.02,31s-18.78-0.02-23.5,1.11 c-2.54,0.64-4.5,2.37-5.21,4.56l-0.01,0.05c-1.75,7.95-1.76,17.49,0.08,26l-0.08-0.43c0.73,2.24,2.68,3.97,5.17,4.6l0.05,0.01 C31.2,68,50.02,68,50.02,68s18.77,0,23.5-1.11c2.54-0.64,4.5-2.37,5.21-4.56l0.01-0.05c0.8-3.7,1.25-7.95,1.25-12.29 c0-0.16,0-0.32,0-0.48c0-0.15,0-0.32,0-0.5C80,44.66,79.54,40.41,78.67,36.29L78.67,36.29z M44.02,57.45V41.57l15.67,7.95 L44.02,57.45z"/>
									</svg>
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-2 footer-tab">
				<div class="footer-info">
					<h3 class="footer-head w10">Important Links</h3>
					<ul class="link">
						<li><a href="https://onnorokomshop.com/Privacy-Policy">Privacy &amp; Policy</a></li>
						<li><a href="https://onnorokomshop.com/terms-and-conditions">Terms &amp; Conditions</a></li>
						<li><a href="https://onnorokomshop.com/about">About {{ SiteInfo()->site_name }}</a></li>
						<li><a href="https://onnorokomshop.com/contact">Contact</a></li>
					</ul>
				</div>
			</div>
			<div class="col-2 footer-tab">
				<div class="footer-info">
					<h3 class="footer-head w10">Our Services</h3>
					<ul class="link">
						<li><a target="_blank" rel="noreferrer" href="http://blog.onnorokomshop.com">News</a></li>
						<li><a target="_blank" href="https://onnorokomshop.com/FAQ">FAQ</a></li>
						<li><a target="_blank" href="https://onnorokomshop.com/sitemap3.xml">XML Site Map</a></li>
						<li><a href="#">Architecture Design</a></li>
					</ul>
				</div>
			</div>
			<div class="col-2 footer-tab">
				<div class="footer-info">
					<h3 class="footer-head w10">Contact Us</h3>
					<ul class="link">
						<li><a target="_blank" rel="noreferrer" href="http://blog.onnorokomshop.com">{{ SiteInfo()->mail }}</a></li>
						<li><a target="_blank" href="https://onnorokomshop.com/sitemap3.xml">{{ SiteInfo()->mobile }}</a></li>
						<li><a target="_blank" href="https://onnorokomshop.com/FAQ">Mymensingh, Sadar</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="developer row">
			<p>Anondho Shop. © 2020. All Rights Reserved</p>
			<p>Develop By &nbsp;<a href="#">Md.Shamim Haque</a></p>
		</div>
	</div>
</footer>