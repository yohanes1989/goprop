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
					<li class="active"><a href="account-fullsales.php"><img src="assets/images/icon-user-fullsales.png" alt=""> <span>Full Sales Progression</span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xs-8 user-content-wrapper">
		<div class="row">
			<div class="alert-custom alert-red">You have signed up for <strong><i>PREMIUM PACKAGE</i></strong></div>			
		</div>

		<div class="user-content-begin col-xs-12">

			<div class="row">
				<div class="col-sm-8 register-form-wrapper">
					<header class="header-area">
						<h3 class="entry-title">Full Sales Progression</h3>
					</header>
					<div class="entry-content">
						<div class="row">
							<div class="col-sm-4 box-simple-child">
								<div class="img-wrap">
									<a href=""><img src="assets/images/icon-pdf.jpg" class="img-responsive" /></a>
								</div>
								<header class="entry-header text-center">
									<h5 class="entry-title">Week 1 Report</h5>
								</header>
							</div>
							<div class="col-sm-4 box-simple-child">
								<div class="img-wrap">
									<a href=""><img src="assets/images/icon-pdf.jpg" class="img-responsive" /></a>
								</div>
								<header class="entry-header text-center">
									<h5 class="entry-title">Week 2 Report</h5>
								</header>
							</div>
							<div class="col-sm-4 box-simple-child">
								<div class="img-wrap">
									<a href=""><img src="assets/images/icon-pdf.jpg" class="img-responsive" /></a>
								</div>
								<header class="entry-header text-center">
									<h5 class="entry-title">Week 3 Report</h5>
								</header>
							</div>
							<div class="col-sm-4 box-simple-child">
								<div class="img-wrap">
									<a href=""><img src="assets/images/icon-pdf.jpg" class="img-responsive" /></a>
								</div>
								<header class="entry-header text-center">
									<h5 class="entry-title">Week 4 Report</h5>
								</header>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>