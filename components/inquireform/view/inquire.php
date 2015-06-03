<div class="inqform">
    <h2><span>Inquiry Form</span></h2>
	<form class="inquiry_form" method="POST" name="inquiry_form"  role="form">
		<div class="form-group">
			<input type="text" value="<?php echo $yourname;?>" name="yourname" required="required" placeholder="Your First Name" class="form-control">
		</div>
		<div class="form-group">
			<input type="text" value="<?php echo $yourlastname;?>" name="yourlastname" required="required" placeholder="Your Last Name" class="form-control">
		</div>
		<div class="form-group">
			<input type="email" value="<?php echo $email1;?>" name="email1" required="required" placeholder="Your Email Address" class="form-control">
		</div>
		<div class="form-group">
			<input type="text" value="<?php echo $phone_mobile;?>" name="phone_mobile" placeholder="Your Phone Mobile" class="form-control">
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
	<input type="hidden" name="assigned_to" value="<?php echo \CRM_Account::get_instance()->get_account_data('userid'); ?>">
	</form>
</div>
