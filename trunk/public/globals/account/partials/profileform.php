<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Info</h3>
  </div>
  <div class="panel-body">
    <div class="profile-alert alert hide">Error</div>
    <form role="form" class="profile-form" method="POST">
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
			<input type="text" class="form-control" id="phone" value="<?php echo $user_meta['phone'][0];?>" name="phone" placeholder="Phone Number">
		</div>
		<button type="submit" class="btn btn-primary update-profile-btn">Update</button>
	</form>
  </div>
</div>
