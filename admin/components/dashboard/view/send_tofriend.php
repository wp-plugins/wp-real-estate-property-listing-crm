<div class="send-to-friend-content">
	<form class="frm_send_link_mail" method="POST" name="frm_send_link_mail"  class="custom">
	  <div class="send-to-friend-header">
		<h4 class="send-to-friend-title" id="emailme-revealLabel">Send this to a Friend</h4>
	  </div>
	  <div class="send-to-friend-body">
			<div class="sendtofriend-alert alert hide">Error</div>
			<div class="row">
				<div class="col-xs-12 col-md-12"><div class="well well-sm">Friends Email Address</div></div>
				<div class="col-xs-12 col-md-12">
					<input type="email" name="friendsemail" required="required" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12"><div class="well well-sm">Your Name</div></div>
				<div class="col-xs-12 col-md-12">
					<input type="text" name="yourname" required="required" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12"><div class="well well-sm">Your Email Address</div></div>
				<div class="col-xs-12 col-md-12">
					<input type="text" name="youremail" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12"><div class="well well-sm">Your Message</div></div>
				<div class="col-xs-12 col-lg-12">
					<textarea class="form-control" rows="10" cols="5" name="message" id="message"></textarea>
				</div>
			</div>
	  </div>
	  <div class="send-to-friend-footer">
		<button type="submit" class="btn btn-primary sendtofriend">Send</button></div>
		<input name="action" value="sendtofriend" type="hidden">
		<input name="address" id="address" value="" type="hidden">
	  </div>
	 </form>
</div>
