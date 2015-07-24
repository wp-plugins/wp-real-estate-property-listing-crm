<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Info</h3>
  </div>
  <div class="panel-body">
    <div class="profile-alert alert hide">Error</div>

    <form role="form" class="profile-form" method="POST" action="<?php echo $url; ?>">
		<div class="form-group">
			<label>First Name</label>
			<input type="text" class="form-control" value="<?php echo $user_account->user_firstname;?>" id="firstname" name="firstname" placeholder="First Name">
		</div>
		<div class="form-group">
			<label>Last Name</label>
			<input type="text" class="form-control" value="<?php echo $user_account->user_lastname;?>" id="lastname" name="lastname" placeholder="Last Name">
		</div>
		<div class="form-group">
			<label>Email Address</label>
			<input type="email" class="form-control" value="<?php echo $user_account->user_email;?>" id="emailaddress" name="emailaddress" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label>Phone</label>
			<input type="text" class="form-control" id="phone" value="<?php echo $phone_number;?>" name="phone" placeholder="Phone Number">
		</div>
		<input type="hidden" name="task" value="update_profile">
		<button type="submit" class="btn btn-primary update-profile-btn">Update</button>
		<div class="profile_msg"></div>
	</form>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Password</h3>
  </div>
  <div class="panel-body">
	<div class="password-alert alert hide">Error</div>
    <form role="form" class="password-form" method="POST" action="<?php echo $url; ?>">
		<div class="form-group">
			<input type="password" class="form-control" value="" id="password" name="password" placeholder="New Password" required>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" value="" id="confirm-password" name="confirm-password" placeholder="Confirm New Password" required>
		</div>
		<input type="hidden" name="task" value="update_password">
		<button type="submit" class="btn btn-primary set-password">Update</button>
		<div class="password_msg"></div>
	</form>
  </div>
</div>
