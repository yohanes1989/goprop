<?php include('header.php'); ?>
<div class="general-page">
	<section class="slideshow-columns">
		<img src="assets/images/banner-3.jpg" class="img-responsive" alt="">
	</section>

	<section class="userform-columns">
		<div class="container">
			<div class="col-xs-12">
				<div class="header-area clearfix">
					<h3 class="entry-title">Register with Go Prop</h3>
					<div class="entry-register"><a href="login.php" class="btn btn-grey">Already have an account? Login here</a></div>
				</div>
				<div class="entry-desc">
					<p>Register to sell your property, or if you're a buyer or tenant, register to ask seller/landlords a question or to arrange a viewing.</p>
					<p><sup class="text-danger">*</sup> Required field</p>
				</div>
			</div>
			<div class="col-xs-12 register-form-wrapper">
				<form>
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Username <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Password <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="password" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Email Address <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Confirm Password <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="password" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<hr class="form-divider" />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Title</label>
									</div>
									<div class="col-sm-8">
										<select class="form-control">
											<option>Please select&hellip;</option>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>First Name <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Surname <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Address</label>
									</div>
									<div class="col-sm-8">
										<textarea class="form-control" rows="8"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Mobile Phone Number <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Home Phone Number</label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group clearfix hidden-xs">
									<div class="col-sm-4">
										<label>&nbsp;</label>
									</div>
									<div class="col-sm-8">
										<p>&nbsp;</p>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Postcode</label>
									</div>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<hr class="form-divider" />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>I have property to sell <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<select class="form-control">
											<option>Please select&hellip;</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>I have property to rent <sup class="text-danger">*</sup></label>
									</div>
									<div class="col-sm-8">
										<select class="form-control">
											<option>Please select&hellip;</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<hr class="form-divider" />
						</div>
					</div>
					<div class="row">
						<div class="form-group clearfix">
							<div class="col-sm-2 col-xs-4">
								<div id="userform-pic">
									<img src="assets/images/profile_pic_default.jpg" class="img-responsive">
								</div>
							</div>
							<div class="col-sm-10 col-xs-8">
								<header class="entry-header">
									<h4 class="entry-title">Profile picture <span class="text-muted">(optional)</span></h4>
								</header>
								<div class="entry-content">
									<p>Upload an profile picture to represent you on GoProp. GoProp will use default Gravatar picture if you don't upload one here. Maximum file size 2MB, ideal dimensions 250x250 pixels</p>
									<p>&nbsp;</p>
								</div>
								<div class="btn btn-yellow file-input-button">
									<span>Upload your profile pic</span>
									<input id="inputProfilePic" type="file">
								</div>
							</div>
						</div>
						<div class="form-group clearfix">
							<div class="col-xs-12">
								<label>Where did you hear about GoProp <sup class="text-danger">*</sup></label>
							</div>
							<div class="col-xs-12">
								<select class="form-control">
									<option>Please select&hellip;</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<hr class="form-divider" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group clearfix">
								<div class="checkbox">
									<label>
										<input type="checkbox">
										I would like to receive notifications for viewings / offers / messages in your vendor app.
									</label>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="checkbox">
									<label>
										<input type="checkbox">
										I want to receive text notifications for viewings / offers.
									</label>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="checkbox">
									<label>
										<input type="checkbox" checked>
										I want to receive news and updates form GoProp. Please note that we still need to send you system notifications.
									</label>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="checkbox">
									<label>
										<input type="checkbox" checked>
										I wish to receive news form GoProp's selected partners and property related services
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<hr class="form-divider" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button class="btn btn-yellow">Register</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>

	<div class="clearfix"></div>
</div>
<?php include('footer.php'); ?>