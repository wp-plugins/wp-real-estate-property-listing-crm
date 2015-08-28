<div class="agent">
	<div class="row">
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo $agent->get_photo();?>" class="img-responsive" style="" />
		</div>
		<div class="col-md-6 col-xs-12">
			<address>
			  <strong>
					<span>Real Estate Agent</span>
					<h5>
						<?php echo $agent->get_name();?>
					</h5>
					<a href="mailto:<?php echo $agent->get_email();?>" target="_blank" title="Click to Email">
						Click to Email
					</a><br>
					<abbr title="Work Phone"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span><?php echo $agent->get_phone();?></abbr><br />
					<abbr title="Mobile Phone"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span><?php echo $agent->get_mobile_num();?></abbr> <br />
			  </strong>
			</address>
			<br>
			<h3>Connect With Us</h3>
			<ul class="list-unstyled agent-box" style="padding-top:10px;">
				<?php if( $agent->get_facebook() != ''){ ?>
					<li><a href="<?php echo $agent->get_facebook();?>" target="_blank"><img src="<?php echo PLUGIN_ASSET_URL;?>fb-icon.png"/></a></li>
				<?php } ?>
				<?php if( $agent->get_twitter() != ''){ ?>
					<li><a href="<?php echo $agent->get_twitter();?>" target="_blank"><img src="<?php echo PLUGIN_ASSET_URL;?>twit-icon.png"/></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
