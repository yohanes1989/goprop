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

		<div class="user-content-begin">
			<div class="col-sm-8">
				<header class="header-area">
					<h3 class="entry-title">Main Details</h3>
				</header>
				<div class="entry-content">
					<p>Tell us all about your propety. <sup class="text-danger">*</sup> Required filed</p>
				</div>
				<div class="row">
					<div class="register-form-wrapper">
						<form>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Property Name / Number <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Address <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<textarea class="form-control" rows="7"></textarea>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Country <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<select name="" id="" class="form-control">
												<option>Please select&hellip;</option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Town/City <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<select name="" id="" class="form-control">
												<option>Please select&hellip;</option>
											</select>
											<div class="text-right">
												<p></p>
												<p><small><a href="">Missing form?</a></small></p>
											</div>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Postcode <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<hr class="form-divider" />
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Property Type <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<select name="" id="" class="form-control">
												<option>Please select&hellip;</option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Bedrooms <sup class="text-danger">*</sup></label>
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
											<label>Garage <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<select name="" id="" class="form-control">
												<option>Please select&hellip;</option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Bathrooms/W.Cs <sup class="text-danger">*</sup></label>
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
									<h3 class="entry-title">Listing Details</h3>
								</header>
								<div class="entry-content">
									<p>Please fill in the details below, about the property you area advertising on GoProp</p>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Are you selling your property? <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<select name="" id="" class="form-control">
												<option>Yes</option>
												<option>No</option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<div>Viewing Option:</div>
											<label class="checkbox-inline">
												<input type="checkbox"> Weekdays
											</label>
											<label class="checkbox-inline">
												<input type="checkbox"> Weekend
											</label>
										</div>
									</div>									
								</div>
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Price</label>
										</div>
										<div class="col-xs-12">
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<p>&nbsp;</p>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Are you renting your property? <sup class="text-danger">*</sup></label>
										</div>
										<div class="col-xs-12">
											<select name="" id="" class="form-control">
												<option>Yes</option>
												<option selected="selected">No</option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<div>Viewing Schedule Option:</div>
											<label class="checkbox-inline">
												<input type="checkbox"> Weekdays
											</label>
											<label class="checkbox-inline">
												<input type="checkbox"> Weekend
											</label>
										</div>
									</div>	
								</div>
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="col-xs-12">
											<label>Asking Rent</label>
										</div>
										<div class="col-xs-12">
											<div class="row">
												<div class="col-xs-8"><input type="text" class="form-control"></div>
												<div class="col-xs-4">
													<select class="form-control">
														<option>Month</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12"><p>&nbsp;</p></div>
								<div class="col-xs-6 text-center">
									<button class="btn btn-yellow">Save Information</button>
								</div>
								<div class="col-xs-6 text-center">
									<a href="account-properties-2.php" class="btn btn-yellow">Save &amp; Continue</a>
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
<?php include('footer.php'); ?>