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

			<div class="row">
				<div class="col-sm-8">
					<header class="header-area">
						<h3 class="entry-title">Select a Package for <span>Rumah Dijual Jln. Cideng no. 123 </span></h3>
					</header>
					<div class="entry-content">
						<p>Please select from one of the packages below. Please note that your property will need to be verified before it goes live to this may take a few days. We will contact you soon about the verification process.</p>
					</div>
					<div class="property-table-columns col-xs-12">
						<!-- Custom Tabs -->
						<div class="custom-tabs">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs text-right" role="tablist">
								<li role="presentation" class="active"><a href="#sell-property" aria-controls="sell-property" role="tab" data-toggle="tab">Sell My Property</a></li>
								<li role="presentation"><a href="#rent-property" aria-controls="rent-property" role="tab" data-toggle="tab">Rent My Property</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="sell-property">
									<header class="entry-header text-center">
										<h3 class="entry-title">Sell My Property</h3>
									</header>
									<div class="entry-content">
										<table class="table table-custom">
											<thead>
												<tr>
													<th width="40%">&nbsp;</th>
													<th width="20%" class="colored blue">Basic</th>
													<th width="20%" class="colored yellow">Exclusive</th>
													<th width="20%" class="colored red">Premium</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Our fee: Only pay when your property is sold</td>
													<td class="colored blue"><div class="text">7,000,000</div></td>
													<td class="colored yellow">0,75%</td>
													<td class="colored red">1%</td>
												</tr>
												<tr>
													<td>Property verification visit by GoProp agent</td>
													<td class="colored blue"><span class="icon icon-red"><i class="fa fa-times-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
												</tr>
												<tr>
													<td>Exclusive agency contract with a 4 month tie-in</td>
													<td class="colored blue"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-red"><i class="fa fa-times-circle"></i></span></td>
												</tr>
												<tr>
													<td>Legal setup</td>
													<td class="colored blue"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
												</tr>
												<tr>
													<td>Full sales progression</td>
													<td class="colored blue"><span class="icon icon-red"><i class="fa fa-times-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
												</tr>
												<tr>
													<td>Viewing management</td>
													<td class="colored blue"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
												</tr>
												<tr>
													<td>Viewing feedback</td>
													<td class="colored blue"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
												</tr>
												<tr>
													<td>Offer negotiation</td>
													<td class="colored blue"><span class="icon icon-red"><i class="fa fa-times-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
												</tr>
												<tr>
													<td>Handle by Senior Agent</td>
													<td class="colored blue"><span class="icon icon-red"><i class="fa fa-times-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															1,000,000
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Advertised on major property portal</td>
													<td class="colored blue"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															500,000
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>For sale board</td>
													<td class="colored blue">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															300,000
															</label>
														</div>
													</td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															300,000
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Professional floor plan</td>
													<td class="colored blue">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															350,000
															</label>
														</div>
													</td>
													<td class="colored yellow"><span class="icon icon-blue"><i class="fa fa-check-circle"></i></span></td>
													<td class="colored red">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															350,000
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Professional photography</td>
													<td class="colored blue">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															1,000,000
															</label>
														</div>
													</td>
													<td class="colored yellow">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															750,000
															</label>
														</div>
													</td>
													<td class="colored red">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															1,000,000
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Professional virtual tour</td>
													<td class="colored blue">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															750,000
															</label>
														</div>
													</td>
													<td class="colored yellow">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															500,000
															</label>
														</div>
													</td>
													<td class="colored red">
														<div class="checkbox">
															<label>
															<input type="checkbox" value="">
															750,000
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td><strong>Pay up-front fees</strong></td>
													<td class="colored blue"><div class="text"><strong>2,400,000</strong></div></td>
													<td class="colored yellow"><div class="text"><strong>1,250,000</strong></div></td>
													<td class="colored red"><div class="text"><strong>750,000</strong></div></td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td><strong>Property value</strong></td>
													<td><input type="text" value="IDR 5,000,000,000" class="form-control text-center"></td>
													<td><input type="text" value="IDR 5,000,000,000" class="form-control text-center"></td>
													<td><input type="text" value="IDR 5,000,000,000" class="form-control text-center"></td>
												</tr>
												<tr>
													<td><strong>Projection fee after completion*</strong></td>
													<td><div class="text">IDR 9,400,000</div></td>
													<td><div class="text">IDR 26,250,000</div></td>
													<td><div class="text">IDR 53,900,000</div></td>
												</tr>
												<tr>
													<td><strong>You can save**</strong></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td></td>
													<td>
														<a href="account-properties-7b.php" class="btn btn-yellow">Sign up</a>
													</td>
													<td>
														<a href="account-properties-7b.php" class="btn btn-yellow">Sign up</a>
													</td>
													<td>
														<a href="account-properties-7b.php" class="btn btn-yellow">Sign up</a>
													</td>
												</tr>
											</tfoot>
										</table>

										<div class="col-xs-12">
											<div class="row">
												<div class="notes col-sm-7">
													<div><small>* min fee IDR. 5,000,000</small></div>
													<div><small>** property value x 2.5% (other traditional commission agent) - (property value x go prop fee) + upfront cost</small></div>
												</div>
												<div class="payment col-sm-5">
													<img src="assets/images/payment-logo.png" class="img-responsive">
												</div>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div role="tabpanel" class="tab-pane" id="rent-property">..sadsadsadgregdg.</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>