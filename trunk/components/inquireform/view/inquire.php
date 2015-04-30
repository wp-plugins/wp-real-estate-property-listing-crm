<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Inquire form</h3>
  </div>
  <div class="panel-body">
	<form class="inquiry_form" method="POST" name="inquiry_form"  role="form">
		<div class="form-group">
			<input type="text" name="yourname" required="required" placeholder="Your First Name" class="form-control">
		</div>
		<div class="form-group">
			<input type="text" name="yourlastname" required="required" placeholder="Your Last Name" class="form-control">
		</div>
		<div class="form-group">
			<input type="email" name="email1" required="required" placeholder="Your Email Address" class="form-control">
		</div>
		<div class="form-group">
			<input type="text" name="phone_mobile" placeholder="Your Phone Mobile" class="form-control">
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="10" cols="5" name="message" style="resize: none;" ><?php echo $msg;?></textarea>
		</div>
		<button type="submit" class="btn inquireform btn-primary">Send</button>
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="ajax-msg">

				</div>
			</div>
		</div>
	<input type="hidden" name="assigned_to" value="<?php echo \crm\AccountEntity::get_instance()->get_account_details('userid'); ?>">
	</form>
  </div>
</div>
