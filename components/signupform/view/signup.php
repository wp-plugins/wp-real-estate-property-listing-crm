<!-- Modal -->
<?php //if( have_properties() ){ ?>
<div class="modal fade register-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="register-modal-revealLabel">No Account Yet? Sign Up Now!</h4>
	  </div>

      <div class="modal-body">
			<div class="register-login-alert alert hide">Error</div>
			<div class="row">
				<div class="col-md-12">
					<?php if( !is_user_logged_in() ){ ?>
						<h3>Sign in with...</h3>
						<div class="social-signin">
							<span class="facebook-login"><?php //\Facebook_APP::get_instance()->js_init(); ?></span>
						</div>
					<?php } ?>
					<div class="login-indicator"></div>
				</div>
				<div class="col-md-12">
					<div class="content-text"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<form role="form" class="register-form" method="POST">
						<h2>Register</h2>
						<div class="form-group">
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" id="emailaddress" name="emailaddress" placeholder="Enter email">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
						</div>
						<input type="hidden" name="current_action" class="current_action">
						<input type="hidden" name="data_post" class="data_post">
						<button type="submit" class="btn btn-primary registersend">Sign-up</button>
					</form>
				</div>
				<div class="col-md-6">
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
						<input type="hidden" name="current_action" class="current_action">
						<input type="hidden" name="data_post" class="data_post">
						<button type="submit" class="btn btn-primary modal-login">Login</button>
					</form>
				</div>
			</div>
      </div>

      <div class="modal-footer">
		<button type="button" class="btn btn-primary closemodal" data-dismiss="modal">Close</button>
      </div>

    </div>
   </div>
</div>
<?php //} ?>
