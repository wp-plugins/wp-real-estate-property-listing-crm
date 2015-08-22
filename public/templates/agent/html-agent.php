<div class="agent">
	<div class="row">
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo $agent->get_photo();?>" class="img-responsive" />
		</div>
		<div class="col-md-6 col-xs-12">
			<h5><span>Agent</span></h5>
			<address>
			  <strong>
					<h5>
						<?php echo $agent->get_name();?>
					</h5>
					<a href="mailto:<?php echo $agent->get_email();?>" target="_blank" title="Click to Email">
						Click to Email
					</a>
					<abbr title="Work Phone">Work:</abbr> <?php echo $agent->get_phone();?><br />
					<abbr title="Mobile Phone">Mobile:</abbr> <?php echo $agent->get_mobile_num();?><br />
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
