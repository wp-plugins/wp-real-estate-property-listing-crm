<div class="register-login-alert alert hide">Error</div>
<div class="row">
	<div class="col-md-12">
		<div class="content-text"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<form role="form" class="register-form" method="POST">
			<h3>Register</h3>
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
			<h3>Login</h3>
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
		<h3>Or</h3>
		<div class="social-login">
			<?php if( !is_user_logged_in() ){ ?>
				<div class="social-signin">
					<div id="status"></div>
					<?php \MD_Facebook_App::get_instance()->login_button(); ?>
				</div>
			<?php } ?>
			<div class="login-indicator"></div>
		</div>
		<p></p>
	</div>
</div>
