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
					<li><a href="account-properties-1.php"><img src="assets/images/icon-user-properties.png" alt=""> <span>Properties</span></a></li>
					<li><a href="account-fullsales.php"><img src="assets/images/icon-user-fullsales.png" alt=""> <span>Full Sales Progression</span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xs-8 user-content-wrapper">
		<div class="row">
			<div class="alert-custom alert-red">You have signed up for <strong><i>PREMIUM PACKAGE</i></strong></div>			
		</div>

		<div class="user-content-begin">
			<div class="col-sm-8">

				<header class="header-area">
					<h3 class="entry-title">Your GoProp Account</h3>
				</header>
				<div class="entry-content">
					<p>Make changes to your GoProp account here. <sup class="text-danger">*</sup> Required filed</p>
				</div>
				
				<div class="register-form-wrapper">
					<form>
						<div class="row">
							<div class="col-sm-6">
								<div class="row">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Username <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Password <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="password" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Email Address <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Confirm Password <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
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
										<div class="col-xs-12">
											<label>Title</label>
										</div>
										<div class="col-xs-12">
											<select class="form-control">
												<option>Please select&hellip;</option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>First Name <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Surname <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Address</label>
										</div>
										<div class="col-xs-12">
											<textarea class="form-control" rows="8"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Mobile Phone Number <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Home Phone Number</label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix hidden-xs">
										<div class="col-xs-12">
											<label>&nbsp;</label>
										</div>
										<div class="col-xs-12">
											<p style="margin-bottom: 15px;">&nbsp;</p>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Postcode</label>
										</div>
										<div class="col-xs-12">
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
										<div class="col-xs-12">
											<label>I have property to sell <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
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
										<div class="col-xs-12">
											<label>I have property to rent <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
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
											<input type="checkbox" checked>
											I would like to receive notifications for viewings / offers / messages in your vendor app.
										</label>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="checkbox">
										<label>
											<input type="checkbox" checked>
											I want to receive text notifications for viewings / offers.
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
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>