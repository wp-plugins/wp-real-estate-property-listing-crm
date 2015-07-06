<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Password</h3>
  </div>
  <div class="panel-body">
	<div class="password-alert alert hide">Error</div>
    <form role="form" class="password-form" method="POST" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>profile">
		<div class="form-group">
			<input type="password" class="form-control" value="" id="password" name="password" placeholder="New Password" required>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" value="" id="confirm-password" name="confirm-password" placeholder="Confirm New Password" required>
		</div>
		<input type="hidden" name="task" value="update_password">
		<button type="submit" class="btn btn-primary set-password">Save</button>
		<div class="password_msg"></div>
	</form>
  </div>
</div>
