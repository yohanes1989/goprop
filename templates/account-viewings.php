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
					<li class="active"><a href="account-viewings.php"><img src="assets/images/icon-user-viewings.png" alt=""> <span>Viewings</span></a></li>
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
					<h3 class="entry-title">Viewings Calendar</h3>
				</header>
				<div class="row">
					<div class="col-sm-6">
						 <div id="datetimepicker12"></div>
						 <div class="viewing-calendar-area">
						 	<div class="view-list">
						 		<span class="icon bg-yellow"></span> <a href="">View of my property</a>
						 	</div>
						 	<div class="view-list">
						 		<span class="icon bg-green"></span> <a href="">Properties I'm viewing</a>
						 	</div>
						 </div>
					</div>
					<div class="col-sm-6">
						<div class="property-schedule clearfix">
							<div class="icon">
								<img src="assets/images/icon-user-viewings.png" alt="">
							</div>
							<div class="property-detail">
								<div class="img-wrap">
									<img src="assets/images/property-1.jpg" alt="" class="img-responsive">
								</div>
								<header class="entry-header">
									<h3 class="entry-title">Villa Dei Tramonti</h3>
									<h5 class="entry-desc">Viewing scheduled:</h5>
									<h5 class="entry-desc"><strong>Sat, 26th Nov 2015 09:00</strong></h5>
								</header>
								<div class="entry-button">
									<a href="" class="btn btn-yellow">Change Date</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>

		<div class="user-content-begin">
			<div class="col-sm-8">
				<header class="header-area">
					<h3 class="entry-title">Feedback Receieve</h3>
				</header>
				<div class="row">
					<div class="feedback-content-area">
						<h3 class="text-center text-muted title-empty">You haven’t received any feedback yet</h3>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>