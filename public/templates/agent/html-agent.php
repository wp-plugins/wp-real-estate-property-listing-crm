<div class="agent">
	<h2><span>Agent</span></h2>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<img src="<?php echo $agent->get_photo();?>" class="img-responsive" />
		</div>
		<div class="col-md-12 col-xs-12">
			<address>
			  <strong>
					<h3>
						<a href="mailto:<?php echo $agent->get_email();?>" target="_blank" title="Click to Email">
							<?php echo $agent->get_name();?>
						</a>
						<?php echo $agent->get_company();?>
					</h3>
					<br>
					<abbr title="Work Phone">Work:</abbr> <?php echo $agent->get_phone();?><br />
					<abbr title="Mobile Phone">Mobile:</abbr> <?php echo $agent->get_mobile_num();?><br />
					<abbr title="Website">Website:</abbr> <a href="http://<?php echo $agent->get_website();?>" target="_blank"><?php echo $agent->get_website();?></a><br />
			  </strong>
			</address>
			<br>
			<h3>Connect With Us</h3>
			<ul class="list-unstyled agent-box" style="padding-top:10px;">
				<li><a href="<?php echo $agent->get_facebook();?>" target="_blank"><img src="<?php echo PLUGIN_ASSET_URL;?>fb-icon.png"/></a></li>
				<li><a href="<?php echo $agent->get_twitter();?>" target="_blank"><img src="<?php echo PLUGIN_ASSET_URL;?>twit-icon.png"/></a></li>
			</ul>
		</div>
	</div>
</div>
