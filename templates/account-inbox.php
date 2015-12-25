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
					<li class="active"><a href="account-inbox.php"><img src="assets/images/icon-user-inbox.png" alt=""> <span>Inbox</span></a></li>
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

		<div class="user-content-begin col-xs-12">

			<div class="row">
				<div class="col-sm-12 col-md-8 register-form-wrapper">
					<header class="header-area">
						<h3 class="entry-title">Inbox</h3>
						<div class="entry-button"><a href="account-inbox-new.php"><img src="assets/images/icon-inbox-new.png" /> Add Messages</a></div>
					</header>
					<div class="entry-content">
						<div class="inbox-content-wrapper">
							<div class="row">
								<div class="form-group col-sm-6">
									<label>Your properties</label>
									<select class="form-control">
										<option>No properties in talks</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label>Properties you're interested in</label>
									<select class="form-control">
										<option>You're not interested in any properties</option>
									</select>
								</div>
							</div>
							<div class="chat-content-wrapper">
								<div class="chat-inner-wrapper empty-chat">
									<div class="feedback-content-area">
										<h3 class="text-center text-muted title-empty">Please select a property above first</h3>
									</div>									
								</div>
								<div class="text-center">
									<small>You have not uploaded any properties, not have you shown any interest in a property yet.<br />
									Add your property now or search for property you're interested in to see it here.</small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-4"></div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>