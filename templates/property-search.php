<?php include('header.php'); ?>
<div class="general-page">
	<section class="property-search-columns">
		<div class="top-content">
			<div class="container">
				<div class="col-sm-8">
					<header class="header-area">
						<h3 class="entry-title">Property for sale in <strong>Jakarta Pusat</strong></h3>
					</header>
				</div>
				<div class="col-sm-4">
					<div class="other-link">
						<a href=""><i class="fa fa-bars"></i> Submit Property</a>
					</div>
				</div>
			</div>
			<div class="map-container">				
				<div class="iframe-responsive iframe-responsive-16x9">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.537936685751!2d106.83657325036773!3d-6.192521695494962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f43fa6c96e93%3A0xb7e51f38ccfa8b61!2sJl.+Cikini+Raya%2C+Menteng%2C+Kota+Jakarta+Pusat%2C+Daerah+Khusus+Ibukota+Jakarta+10330!5e0!3m2!1sid!2sid!4v1446699566126" width="800" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="mid-content">
			<div class="container">
				<div class="col-sm-9">
					<div class="row">
						<div class="form-group col-sm-3">
							<select name="" class="form-control">
								<option>All Actions</option>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<select name="" class="form-control">
								<option>All Cities</option>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<select name="" class="form-control">
								<option>All Areas</option>
							</select>
						</div>
						<div class="form-group col-sm-3">&nbsp;</div>
						<div class="clearfix"></div>
						<div class="form-group col-sm-3">
							<select name="" class="form-control">
								<option>All Types</option>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<select name="" class="form-control">
								<option>Min. Rooms</option>
							</select>
						</div>
						<div class="form-group col-sm-6">
							<div>Price range: <strong>IDR 1,000,000,000 to IDR 2,000,000,000</strong></div>
							<input type="text" id="inputPriceRange" value="" data-slider-min="1000000000" data-slider-max="2000000000" 
																			 data-slider-step="5" data-slider-value="[1000000000,2000000000]" />
						</div>
					</div>
				</div>
				<div class="col-sm-3 form-submit">
					<button class="btn btn-yellow btn-submit">Search Properties</button>
				</div>
				<div class="col-xs-12">
					<hr class="form-divider" />
				</div>
			</div>
		</div>

		<div class="bottom-content">
			<div class="container">
				<div class="col-sm-8">
					<div class="property-search-wrapper">
						<header class="header-area">
							<h3 class="entry-title">Advanced Search (15)</h3>
							<div class="entry-desc">
								<p>By logging in, you can save this search and receive instant email notification whenever new properties matching your search are published.</p>
							</div>
						</header>
						<div class="entry-detail">
							<div class="row">
								<div class="col-sm-3">
									<select name="" id="" class="form-control">
										<option>By price</option>
									</select>
								</div>
								<div class="col-sm-7"></div>
								<div class="col-sm-2 grid-setting">
									<a href="" class="active"><i class="fa fa-bars"></i></a>
									<a href=""><i class="fa fa-th"></i></a>
								</div>
							</div>
						</div>
						<div class="property-compare-wrapper clearfix">
							<h3 class="entry-title">Compare properties</h3>
							<div class="property-compare-list">
								<div class="propertyCompare-child">
									<a href=""><img src="assets/images/property-1.jpg"></a>
								</div>
								<div class="propertyCompare-child">
									<a href=""><img src="assets/images/property-2.jpg"></a>
								</div>
								<div class="propertyCompare-child">
									<a href=""><img src="assets/images/property-3.jpg"></a>
								</div>
								<div class="propertyCompare-child btn-submit">
									<a href="property-search-compare.php" class="btn btn-yellow btn-shadow">Compare</a>
								</div>
							</div>
						</div>
						<div class="propertyItem-list">
							<div class="row">
								<?php for ($i=0; $i < 2; $i++) { ?>
								<div class="propertyItem-child col-sm-6">
									<div class="img-wrap">
										<a href=""><img src="assets/images/property-1.jpg" class="img-responsive"></a>
									</div>
									<header class="entry-header clearfix">
										<div class="pull-left">
											<h4 class="entry-title"><a href="">Shakespeare Ranch</a></h4>
											<div class="entry-desc">Glenbrook, Nevada 89413</div>
										</div>
										<div class="pull-right user-info">
											<ul class="list-unstyled">
												<li class="socialShare-to">
													<a href=""><i class="fa fa-share-alt"></i></a>
													<ul>
														<li><a href=""><i class="fa fa-facebook"></i></a></li>
														<li><a href=""><i class="fa fa-twitter"></i></a></li>
														<li><a href=""><i class="fa fa-linkedin"></i></a></li>
														<li><a href=""><i class="fa fa-google-plus"></i></a></li>
														<li><a href=""><i class="fa fa-whatsapp"></i></a></li>
													</ul>
												</li>
												<li><a href=""><i class="fa fa-heart-o"></i></a></li>
												<li><a href=""><i class="fa fa-plus"></i></a></li>
											</ul>
										</div>
									</header>
									<div class="entry-content clearfix">
										<div class="pull-left">
											<div class="featureChild">
												<div class="name">25</div>
												<div class="desc">Beds</div>
											</div>
											<div class="featureChild">
												<div class="name">9</div>
												<div class="desc">Baths</div>
											</div>
										</div>
										<div class="pull-right">
											<h3 class="entry-price">98,000,000</h3>
										</div>
									</div>
								</div>
								<div class="propertyItem-child col-sm-6">
									<div class="img-wrap">
										<a href=""><img src="assets/images/property-2.jpg" class="img-responsive"></a>
									</div>
									<header class="entry-header clearfix">
										<div class="pull-left">
											<h4 class="entry-title"><a href="">Big Scrub - Scrub Island</a></h4>
											<div class="entry-desc">Big Scrub, Scrub Island British Virgin Island</div>
										</div>
										<div class="pull-right user-info">
											<ul class="list-unstyled">
												<li class="socialShare-to">
													<a href=""><i class="fa fa-share-alt"></i></a>
													<ul>
														<li><a href=""><i class="fa fa-facebook"></i></a></li>
														<li><a href=""><i class="fa fa-twitter"></i></a></li>
														<li><a href=""><i class="fa fa-linkedin"></i></a></li>
														<li><a href=""><i class="fa fa-google-plus"></i></a></li>
														<li><a href=""><i class="fa fa-whatsapp"></i></a></li>
													</ul>
												</li>
												<li><a href=""><i class="fa fa-heart-o"></i></a></li>
												<li><a href=""><i class="fa fa-plus"></i></a></li>
											</ul>
										</div>
									</header>
									<div class="entry-content clearfix">
										<div class="pull-left">
											&nbsp;
										</div>
										<div class="pull-right">
											<h3 class="entry-price">Price Upon Request</h3>
										</div>
									</div>
								</div>
								<div class="propertyItem-child col-sm-6">
									<div class="img-wrap">
										<a href=""><img src="assets/images/property-3.jpg" class="img-responsive"></a>
									</div>
									<header class="entry-header clearfix">
										<div class="pull-left">
											<h4 class="entry-title"><a href="">Shakespeare Ranch</a></h4>
											<div class="entry-desc">Glenbrook, Nevada 89413</div>
										</div>
										<div class="pull-right user-info">
											<ul class="list-unstyled">
												<li class="socialShare-to">
													<a href=""><i class="fa fa-share-alt"></i></a>
													<ul>
														<li><a href=""><i class="fa fa-facebook"></i></a></li>
														<li><a href=""><i class="fa fa-twitter"></i></a></li>
														<li><a href=""><i class="fa fa-linkedin"></i></a></li>
														<li><a href=""><i class="fa fa-google-plus"></i></a></li>
														<li><a href=""><i class="fa fa-whatsapp"></i></a></li>
													</ul>
												</li>
												<li><a href=""><i class="fa fa-heart-o"></i></a></li>
												<li><a href=""><i class="fa fa-plus"></i></a></li>
											</ul>
										</div>
									</header>
									<div class="entry-content clearfix">
										<div class="pull-left">
											<div class="featureChild">
												<div class="name">25</div>
												<div class="desc">Beds</div>
											</div>
											<div class="featureChild">
												<div class="name">9</div>
												<div class="desc">Baths</div>
											</div>
										</div>
										<div class="pull-right">
											<h3 class="entry-price">98,000,000</h3>
										</div>
									</div>
								</div>
								<div class="propertyItem-child col-sm-6">
									<div class="img-wrap">
										<img src="assets/images/property-4.jpg" class="img-responsive">
									</div>
									<header class="entry-header clearfix">
										<div class="pull-left">
											<h4 class="entry-title">Shakespeare Ranch</h4>
											<div class="entry-desc">Glenbrook, Nevada 89413</div>
										</div>
										<div class="pull-right user-info">
											<ul class="list-unstyled">
												<li class="socialShare-to">
													<a href=""><i class="fa fa-share-alt"></i></a>
													<ul>
														<li><a href=""><i class="fa fa-facebook"></i></a></li>
														<li><a href=""><i class="fa fa-twitter"></i></a></li>
														<li><a href=""><i class="fa fa-linkedin"></i></a></li>
														<li><a href=""><i class="fa fa-google-plus"></i></a></li>
														<li><a href=""><i class="fa fa-whatsapp"></i></a></li>
													</ul>
												</li>
												<li class="checked"><a href=""><i class="fa fa-heart"></i></a></li>
												<li><a href=""><i class="fa fa-plus"></i></a></li>
											</ul>
										</div>
									</header>
									<div class="entry-content clearfix">
										<div class="pull-left">
											<div class="featureChild">
												<div class="name">25</div>
												<div class="desc">Beds</div>
											</div>
											<div class="featureChild">
												<div class="name">9</div>
												<div class="desc">Baths</div>
											</div>
										</div>
										<div class="pull-right">
											<h3 class="entry-price">98,000,000</h3>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<nav class="paginate-custom">
							<ul class="pagination">
								<li class="active"><a href="">1</a></li>
								<li><a href="">2</a></li>
								<li><a href="">3</a></li>
								<li><a href="">4</a></li>
								<li><a href=""><i class="fa fa-angle-right"></i></a></li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="widget-child">
						<div class="login-form-widget">
							<h4 class="entry-title">Login</h4>
							<div class="login-form-wrapper">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Username" />
								</div>
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Password" />
								</div>
								<div class="form-group">
									<button class="btn btn-yellow btn-shadow btn-submit">LOGIN</button>
								</div>
								<div class="form-detail">
									<a href="register.php">Don't have an account? Register here</a>
									<a href="forgot-password">Forgot Password?</a>
									<a href="" class="with-facebook clearfix">										
										<span class="text">Sign in with Facebook</span>
										<span class="icon"><i class="fa fa-facebook"></i></span>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="widget-child">
						<div class="calling-us-widget">
							<h4 class="entry-title">Call us on 021 999 8888 or let us call you back</h4>
							<div class="entry-content">
								<form>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Name (required)" />
									</div>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Telephone (required)" />
									</div>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Email (required)" />
									</div>
									<div class="form-group">
										<select class="form-control">
											<option>Reason for enquiry</option>
										</select>
									</div>
									<div class="form-group btn-submit">
										<button class="btn btn-grey">Request call</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="widget-child">
						<div class="searching-form-widget">
							<form class="form-inline">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Type Keyword">
								</div>
								<div class="form-group">
									<button class="btn btn-yellow btn-shadow">Search</button>
								</div>
							</form>
						</div>
					</div>
					<div class="widget-child">
						<div class="calculate-price-widget estimated-property-sale">
							<div class="form-begin">
								<div class="form-group">
									<label>Your Estimated Property Sale Price</label>
									<input type="text" id="inputPropertyPrice" value="" data-slider-min="0" data-slider-max="2000000000" 
																				 data-slider-step="5" data-slider-value="1000000000" />
								</div>
								<div class="form-group">
									<small>Adjust the slider to match your property value</small>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-detail">
								<strong>You can save:</strong>
								<h2 class="entry-title">IDR 700.843**</h2>
								<p>** When you sell your property with <strong>GoProp</strong></p>
							</div>
						</div>
					</div>
					<div class="widget-child">
						<div class="exclusive-property-carousel">
							<div id="exclusivePropertyWidget-list">
								<div class="exclusiveProperty-item">
									<a href="">
										<img src="assets/images/exclusive-property-1.jpg" />
										<div class="exclusiveProperty-overlay">
											<div class="exclusiveProperty-detail">
												<h3 class="entry-title">Three Sister</h3>
												<div class="entry-desc">Amagansett</div>
											</div>
										</div>
									</a>
								</div>
								<div class="exclusiveProperty-item">
									<a href="">
										<img src="assets/images/exclusive-property-2.jpg" />
										<div class="exclusiveProperty-overlay">
											<div class="exclusiveProperty-detail">
												<h3 class="entry-title">Three Sister</h3>
												<div class="entry-desc">Amagansett</div>
												<div class="entry-sale">For Sale</div>
											</div>
										</div>
									</a>
								</div>
								<div class="exclusiveProperty-item">
									<a href="">
										<img src="assets/images/exclusive-property-3.jpg" />
										<div class="exclusiveProperty-overlay">
											<div class="exclusiveProperty-detail">
												<h3 class="entry-title">Three Sister</h3>
												<div class="entry-desc">Amagansett</div>
											</div>
										</div>
									</a>
								</div>
								<div class="exclusiveProperty-item">
									<a href="">
										<img src="assets/images/exclusive-property-4.jpg" />
										<div class="exclusiveProperty-overlay">
											<div class="exclusiveProperty-detail">
												<h3 class="entry-title">Three Sister</h3>
												<div class="entry-desc">Amagansett</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="clearfix"></div>
</div>
<?php include('footer.php'); ?>