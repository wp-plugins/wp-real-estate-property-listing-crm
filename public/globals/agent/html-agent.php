<div class="agent">
	<h2><span>Agent</span></h2>
	<div class="row">
		<div class="col-md-4">
			<img src="<?php echo $agent->get_photo();?>" class="img-responsive" />
		</div>
		<div class="col-md-8">
			<h3><?php echo $agent->get_full_name();?></h3>
			<p><?php echo $agent->get_company();?></p>
			<p><?php echo $agent->get_work_phone();?><br />
			<a href="mailto:<?php echo $agent->get_manager_email();?>" target="_blank">Email <?php echo $agent->get_full_name();?></a><br />
			<?php echo $agent->get_website();?></p>
			<h3>Connect With Us</h3>
			<ul class="list-unstyled agent-box" style="padding-top:10px;">
				<li><a href="<?php echo $agent->get_facebook();?>" target="_blank"><img src="<?php echo PLUGIN_ASSET_URL;?>fb-icon.png"/></a></li>
				<li><a href="<?php echo $agent->get_twitter();?>" target="_blank"><img src="<?php echo PLUGIN_ASSET_URL;?>twit-icon.png"/></a></li>
			</ul>
		</div>
	</div>
</div>
