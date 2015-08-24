<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Info</h3>
  </div>
  <div class="panel-body">
    <form role="form" class="profile-form" method="POST">
		<div class="form-group">
			<input type="text" class="form-control" value="<?php echo $user_account->user_firstname;?>" id="firstname" name="firstname" placeholder="First Name">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" value="<?php echo $user_account->user_lastname;?>" id="lastname" name="lastname" placeholder="Last Name">
		</div>
		<div class="form-group">
			<input type="email" class="form-control" value="<?php echo $user_account->user_email;?>" id="emailaddress" name="emailaddress" placeholder="Enter email">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
		</div>
		<button type="submit" class="btn btn-primary registersend">Update</button>
	</form>
  </div>
</div>
