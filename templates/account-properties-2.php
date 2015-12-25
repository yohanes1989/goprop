<?php include('header.php'); ?>
<div class="general-page my-account-page">
	<div class="col-xs-4 sidebar-menu-wrapper">
		<div class="sidebar-menu">
			<div class="user-picture">
				<img src="assets/images/user-icon.png">
				<div class="user-picture-detail">
					<div>Welcome</div>
					<h4 class="user-picture-name text-uppercase">Pelangi</h4>
					<a href="account-edit-profile.php" class="edit-user-profile">Edit Profile</a>
				</div>
			</div>
			<div class="clearfix"></div>

			<div class="sidebar-nav row">
				<ul>
					<li><a href="account-dashboard.php"><img src="assets/images/icon-user-dashboard.png" alt=""> <span>Dashboard</span></a></li>
					<li><a href="account-inbox.php"><img src="assets/images/icon-user-inbox.png" alt=""> <span>Inbox</span></a></li>
					<li><a href="account-viewings.php"><img src="assets/images/icon-user-viewings.png" alt=""> <span>Viewings</span></a></li>
					<li class="active"><a href="account-properties-1.php"><img src="assets/images/icon-user-properties.png" alt=""> <span>Properties</span></a></li>
					<li><a href="account-fullsales.php"><img src="assets/images/icon-user-fullsales.png" alt=""> <span>Full Sales Progression</span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xs-8 user-content-wrapper">
		<div class="row">
			<div class="alert-custom alert-red">You have signed up for <strong><i>PREMIUM PACKAGE</i></strong></div>			
		</div>

		<div class="user-content-begin col-xs-12">
			<div class="top-navigation">
				<div class="row">
					<div class="col-sm-8">
						<div class="menu-preview">
							<ul class="list-unstyled">
								<li><a href=""><img src="assets/images/property-preview.png" alt="" /> Preview property</a></li>
								<li><a href=""><img src="assets/images/property-disable.png" alt="" /> Disable property</a></li>
							</ul>
						</div>
						<div class="form-wizard-menu">
							<ul class="list-unstyled">
								<li class="active"><a href="">
									<div class="img-wrap"></div>
									<span>Main Details</span>
								</a></li>
								<li class="current"><a href="">
									<div class="img-wrap"></div>
									<span>Property Details</span>
								</a></li>
								<li><a href="">
									<div class="img-wrap"></div>
									<span>Map</span>
								</a></li>
								<li><a href="">
									<div class="img-wrap"></div>
									<span>Photos</span>
								</a></li>
								<li><a href="">
									<div class="img-wrap"></div>
									<span>Floorplan</span>
								</a></li>
								<li><a href="">
									<div class="img-wrap"></div>
									<span>Packages</span>
								</a></li>
							</ul>
							<div class="form-wizard-progressbar">
								<div class="form-wizard-bars" style="width: 8%;"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-4"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8">
					<header class="header-area">
						<h3 class="entry-title">More information about <span>Rumah Dijual Jln. Cideng no. 123 </span></h3>
					</header>
					<div class="row">
						<div class="col-xs-12">
							<header class="header-area">
								<h4 class="entry-title">Description about your property</h4>
							</header>
							<div class="entry-content">
								<p>Complete all the fields below that relates to your property. These additional details will make it easier for people to find your property.</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="register-form-wrapper">
							<form>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group clearfix">
											<div class="col-xs-12">
												<label>Land Size</label>
											</div>
											<div class="col-xs-12">
												<select name="" id="" class="form-control">
													<option>Please select&hellip;</option>
												</select>
											</div>
										</div>
										<div class="form-group clearfix">
											<div class="col-xs-12">
												<label>Building Size</label>
											</div>
											<div class="col-xs-12">
												<select name="" id="" class="form-control">
													<option>Please select&hellip;</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group clearfix">
											<div class="col-xs-12">
												<label>FLoors</label>
											</div>
											<div class="col-xs-12">
												<select name="" id="" class="form-control">
													<option>Please select&hellip;</option>
												</select>
											</div>
										</div>
										<div class="form-group clearfix">
											<div class="col-xs-12">
												<label>Certificate</label>
											</div>
											<div class="col-xs-12">
												<select name="" id="" class="form-control">
													<option>Please select&hellip;</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									<header class="header-area">
										<h4 class="entry-title">Short Description</h4>
									</header>
									<div class="entry-content">
										<p>Insert key features of your property in a few lines.</p>
									</div>
								</div>
								<div class="col-xs-12">
									<div class="form-group clearfix">
										<label>Summary <sup class="text-danger">*</sup></label>
										<div class="textarea-group">
											<div class="textarea-count"><span>300</span> characters remaining</div>
											<textarea class="form-control" rows="8" maxlength="300"></textarea>
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									<header class="header-area">
										<h4 class="entry-title">Virtual Tour</h4>
									</header>
									<div class="entry-content">
										<p>Virtual tours and videos of your home can make all the difference. Add your virtual tour by entering your unique URL in the field below. You can also add Youtube videos here.</p>
									</div>
								</div>
								<div class="col-xs-12">
									<div class="form-group clearfix">
										<label>URL</label>
										<input type="text" class="form-control" placeholder="http://">
									</div>
								</div>
								<div class="col-xs-12">
									<hr class="form-divider" />
								</div>
								<div class="row">
									<div class="col-xs-12"><p>&nbsp;</p></div>
									<div class="col-xs-6 text-center">
										<a href="" class="btn btn-yellow">Skip to Packages</a>
									</div>
									<div class="col-xs-6 text-center">
										<button class="btn btn-yellow">Save Information</button>
										<a href="account-properties-3.php" class="btn btn-yellow">Save &amp; Continue</a>
									</div>
									<div class="col-xs-12"><p>&nbsp;</p></div>
									<div class="col-xs-12"><p>&nbsp;</p></div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>