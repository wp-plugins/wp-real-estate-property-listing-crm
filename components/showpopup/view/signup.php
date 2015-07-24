<!-- Modal -->
<div class="modal fade register-only-modal" id="registerOnlyModal" tabindex="-1" role="dialog" aria-labelledby="registerOnlyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">
		<?php if( \Settings_API::get_instance()->showpopup_settings('close') == 0 ){ ?>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<?php } ?>
		<h4 class="modal-title" id="register-modal-revealLabel">Sign-up now, to continue browsing properties</h4>
	  </div>

      <div class="modal-body">
			<div class="register-login-alert alert hide">Error</div>
			<div class="row">
				<div class="col-md-6">
					<form role="form" class="register-form" method="POST">
						<div class="form-group">
							<input style="width:80% !important;" type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
						</div>
						<div class="form-group">
							<input style="width:80% !important;" type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
						</div>
						<div class="form-group">
							<input style="width:50% !important;" type="email" class="form-control" id="emailaddress" name="emailaddress" placeholder="Enter email">
						</div>
						<div class="form-group">
							<input style="width:50% !important;" type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
						</div>
						<input type="hidden" name="property_id" class="property_id">
						<input type="hidden" name="registeronly" value="1">
						<button type="submit" class="btn btn-primary registersend">Sign-up</button>
					</form>
				</div>
				<div class="col-md-6">
					<?php if( !is_user_logged_in() ){ ?>
						<h3>Sign in with...</h3>
						<div class="social-signin">
							<span class="facebook-login"><?php //\Facebook_APP::get_instance()->js_init(); ?></span>
						</div>
					<?php } ?>
					<div class="login-indicator"></div>
					<div class="login-form">
						<form role="form" class="login-form">
							<h2>Login</h2>
							<div class="form-group">
								<input type="text" class="form-control" name="emailaddress" id="emailaddress" placeholder="Email Address">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							</div>
							<div class="form-group">
								<a href="<?php echo home_url('wp-login.php?action=lostpassword');?>">Forgot password</a>
							</div>
							<input type="hidden" name="property_id" class="property_id">
							<input type="hidden" name="feed" class="feed">
							<button type="submit" class="btn btn-primary modal-login">Login</button>
						</form>
					</div>
				</div>
			</div>
      </div>

      <div class="modal-footer">

      </div>

    </div>
   </div>
</div>
