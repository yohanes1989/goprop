<?php include('header.php'); ?>
<div class="general-page">
	<section class="slideshow-columns">
		<img src="assets/images/banner-3.jpg" class="img-responsive" alt="">
	</section>

	<section class="userform-columns">
		<div class="container">
			<div class="col-xs-12">
				<div class="header-area clearfix">
					<h3 class="entry-title">Login to My Go Prop</h3>
					<div class="entry-register"><a href="register.php" class="btn btn-grey">New? Register Here</a></div>
				</div>
				<div class="entry-desc">
					<p>Please fill in your email address below and we will send you a link to reset your password.</p>
				</div>
			</div>
			<div class="col-xs-12 login-form-wrapper">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<div class="login-with-area">
							<div class="loginwith-child">
								<div class="col-sm-4"></div>
								<div class="col-sm-8">
									<a href="" class="with-facebook clearfix">
										<span class="icon"><i class="fa fa-facebook"></i></span>
										<span class="text">Sign in with Facebook</span>
									</a>
								</div>
							</div>
							<div class="loginwith-child">
								<div class="col-sm-4"></div>
								<div class="col-sm-8">
									<a href="" class="with-google clearfix">
										<span class="icon"><i class="fa fa-google-plus"></i></span>
										<span class="text">Sign in with Google</span>
									</a>
								</div>
							</div>
							<div class="loginwith-child">
								<div class="col-sm-4"></div>
								<div class="col-sm-8">
									<div class="text-center">or</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>						
						<div class="login-form-area">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="" class="control-label col-sm-4">Username <sup class="text-danger">*</sup></label>
									<div class="col-sm-8">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="" class="control-label col-sm-4">Password <sup class="text-danger">*</sup></label>
									<div class="col-sm-8">
										<input type="password" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="" class="control-label col-sm-4">&nbsp;</label>
									<div class="col-sm-8">
										<div class="checkbox">
											<label>
												<input type="checkbox" value="">
												Remember me
											</label>
										</div>
									</div>
								</div>
								<div class="form-group form-submit">
									<div class="col-sm-4"></div>
									<div class="col-sm-8">
										<button class="btn btn-yellow">Login</button>
										<a href="forgot-password.php" class="other-link"><small>Forgot Password?</small></a>
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