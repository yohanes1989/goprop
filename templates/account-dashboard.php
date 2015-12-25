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
					<li class="active"><a href="account-dashboard.php"><img src="assets/images/icon-user-dashboard.png" alt=""> <span>Dashboard</span></a></li>
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
				<!-- Custom Tabs -->
				<div class="custom-tabs">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#property-sell" aria-controls="sell-property" role="tab" data-toggle="tab">Property I'm Sell</a></li>
						<li role="presentation"><a href="#property-interest" aria-controls="rent-property" role="tab" data-toggle="tab">Properties I'm Interest In</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="property-sell">
							<div class="row propertyItem-list">
								<div class="propertyItem-child">
									<div class="col-sm-6">
										<div class="img-wrap">
											<img src="assets/images/property-1.jpg" alt="" class="img-responsive">
										</div>
									</div>
									<div class="col-sm-6 account-property-detail">
										<ul class="list-unstyled">
											<li><a href=""><img src="assets/images/icon-small-email.png"></a></li>
											<li><a href=""><img src="assets/images/icon-small-date.png"></a></li>
											<li><a href=""><img src="assets/images/icon-small-bookmark.png"></a></li>
										</ul>
										<header class="entry-header">
											<h4 class="entry-title"><a href="">Shakespeare Ranch</a></h4>
											<div class="entry-desc">Glenbrook, Nevada 89413</div>
										</header>
										<div class="entry-content">
											<div class="featureChild">
												<div class="name">6</div>
												<div class="desc">Beds</div>
											</div>
											<div class="featureChild">
												<div class="name">7</div>
												<div class="desc">Baths</div>
											</div>
											<div class="clearfix"></div>
											<h3 class="entry-price">98,000,000</h3>
										</div>
									</div>
								</div>
								<div class="propertyItem-child">
									<div class="col-sm-6">
										<div class="img-wrap">
											<img src="assets/images/property-1.jpg" alt="" class="img-responsive">
										</div>
									</div>
									<div class="col-sm-6 account-property-detail">
										<ul class="list-unstyled">
											<li><a href=""><img src="assets/images/icon-small-email.png"></a></li>
											<li><a href=""><img src="assets/images/icon-small-date.png"></a></li>
											<li><a href=""><img src="assets/images/icon-small-bookmark.png"></a></li>
										</ul>
										<header class="entry-header">
											<h4 class="entry-title"><a href="">Shakespeare Ranch</a></h4>
											<div class="entry-desc">Glenbrook, Nevada 89413</div>
										</header>
										<div class="entry-content">
											<div class="featureChild">
												<div class="name">6</div>
												<div class="desc">Beds</div>
											</div>
											<div class="featureChild">
												<div class="name">7</div>
												<div class="desc">Baths</div>
											</div>
											<div class="clearfix"></div>
											<h3 class="entry-price">98,000,000</h3>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 text-center">
								<a href="" class="btn btn-yellow"><i class="fa fa-plus"></i> More Results</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div role="tabpanel" class="tab-pane" id="property-interest">
							b
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>