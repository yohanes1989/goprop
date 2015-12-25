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
								<li class="current"><a href="">
									<div class="img-wrap"></div>
									<span>Floorplan</span>
								</a></li>
								<li><a href="">
									<div class="img-wrap"></div>
									<span>Packages</span>
								</a></li>
							</ul>
							<div class="form-wizard-progressbar">
								<div class="form-wizard-bars" style="width: 24%;"></div>
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
					<div class="entry-content">
						<p>Photos makes your property look more attractive to buyers and showcase the best things about your property. You can add photos up to maximum 50 photos. You can also edit, delete, or re-order the photos at any time.</p>
						<p>I f you have selected professional photography service you can skip this section and come back to this when you have your property ready.</p>
					</div>
					<div class="row">
						<div class="register-form-wrapper">
							<form>
								<div class="col-xs-12">
									<header class="header-area">
										<h4 class="entry-title">Upload Floor Plan Images</h4>
									</header>
									<div class="entry-content">
										<div><label>Upload Image</label></div>
										<div class="btn btn-yellow file-input-button">
											<span>Upload your profile pic</span>
											<input id="inputProfilePic" type="file">
										</div>
										<p></p>
										<div id="userform-pic">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12"><p>&nbsp;</p></div>
									<div class="col-xs-6 text-center">&nbsp;</div>
									<div class="col-xs-6 text-center">
										<a href="account-properties-7.php" class="btn btn-yellow">Save &amp; Continue</a>
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