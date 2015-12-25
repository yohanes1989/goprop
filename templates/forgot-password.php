<?php include('header.php'); ?>
<div class="general-page">
	<section class="slideshow-columns">
		<img src="assets/images/banner-3.jpg" class="img-responsive" alt="">
	</section>

	<section class="userform-columns">
		<div class="container">
			<div class="col-xs-12">
				<div class="header-area clearfix">
					<h3 class="entry-title">Forgot your Password?</h3>
					<div class="entry-register"><a href="register.php" class="btn btn-grey">New? Register Here</a></div>
				</div>
				<div class="entry-desc">
					<p>Please fill in your email address below and we will send you a link to reset your password.</p>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<div class="forgot-password-area">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="" class="control-label col-sm-4">Email Address <sup class="text-danger">*</sup></label>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-4"></div>
									<div class="col-sm-8">
										<button class="btn btn-yellow">Send</button>
										<a href="login.php" class="other-link"><small class="text-muted"><i>Back to login page</i></small></a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</div>
		</div>
	</section>

	<div class="clearfix"></div>
</div>
<?php include('footer.php'); ?>