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
								<li class="active"><a href="">
									<div class="img-wrap"></div>
									<span>Property Details</span>
								</a></li>
								<li class="active"><a href="">
									<div class="img-wrap"></div>
									<span>Map</span>
								</a></li>
								<li class="active"><a href="">
									<div class="img-wrap"></div>
									<span>Photos</span>
								</a></li>
								<li class="active"><a href="">
									<div class="img-wrap"></div>
									<span>Floorplan</span>
								</a></li>
								<li class="current"><a href="">
									<div class="img-wrap"></div>
									<span>Packages</span>
								</a></li>
							</ul>
							<div class="form-wizard-progressbar">
								<div class="form-wizard-bars" style="width: 94%;"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-4"></div>
				</div>
			</div>

			<div class="property-table-columns row">
				<div class="col-sm-8 register-form-wrapper">
					<header class="header-area">
						<h3 class="entry-title">Your Current Package</h3>
					</header>
					<div class="entry-content">
						<p>Option 2:</p>
					</div>
					<header class="header-area">
						<h3 class="entry-title">Your Current Addons</h3>
					</header>
					<div class="entry-content">
						<ul class="list-unstyled">
							<li>Premium Listing</li>
							<li>Photography</li>
							<li>Professional Floor Plan</li>
						</ul>
					</div>
					<header class="header-area">
						<h3 class="entry-title">Total Cost</h3>
					</header>
					<div class="entry-content">
						<div class="checkbox">
							<label>
								<input type="checkbox">
								I agree to the <a href="term-condition.php" class="ajax_popup fancybox.ajax">terms & condition</a>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6"></div>
						<div class="col-sm-6 payment"><img src="assets/images/payment-logo.png" class="img-responsive"></div>
					</div>
					<div class="row">
						<hr class="form-divider">
					</div>
					<div class="form-action row">
						<div class="row">
							<div class="col-sm-6 is-left"><a href="account-properties-8.php" class="btn btn-yellow">Change Package</a></div>
							<div class="col-sm-6 is-right"><a href="" class="btn btn-grey">Cancel</a></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>