<?php if(\MD_Subscribe_API::get_instance()->getError()){ ?>
	<div class="error">
		<ul>
			<?php foreach(\MD_Subscribe_API::get_instance()->getError() as $val) { ?>
					<li><p class="error"><?php echo $val;?></p></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>
<?php if(\API_Credentials::get_instance()->getError()){ ?>
	<div class="error">
		<ul>
			<?php foreach(\API_Credentials::get_instance()->getError() as $val) { ?>
					<li><p class="error"><?php echo $val;?></p></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>
<div class="wrap about-wrap">
	<h1>Welcome to <?php echo esc_html( get_admin_page_title() ); ?> <?php echo \Masterdigm_API::get_instance()->get_version();?></h1>
	<img src="<?php echo PLUGIN_ASSET_URL;?>/banner-772x250.jpg" style="height:100px;">
	<div class="feature-section two-col">
		<div class="col">
			<form name="md_api" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
				<input type="hidden" name="action" value="subscribe_api_key">
				<h3>Sign-up to subscribe masterdigm api</h3>
				<p>Masterdigm real estate CRM pricing goes as low as $9.95 per user/month! We have a tiered pricing structure for the CRM and for Websites depending on how many user seats and websites you need. To learn more about Masterdigm CRM and its features, simply fill out the form below for a demonstration or sign up for a FREE 14 Day trial now. Either way, we can help you to make that right decision</p>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="email">Email <span> *</span>: </label></th>
							<td>
								<input type="text" name="email" value="<?php echo get_option('admin_email');?>" style="width:100%;">
								<p style="font-style:italic;font-size:12px;">please provide email, or change email address, this will be use to signup an account in masterdigm</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="company">Company : </label></th>
							<td><input type="text" name="company" value="<?php echo get_option('blogname');?>" style="width:100%;"></td>
						</tr>
						<tr>
							<th scope="row"><label for="first_name">First Name : </label></th>
							<td><input type="text" name="first_name" value="<?php echo $current_user->user_firstname;?>" style="width:100%;"></td>
						</tr>
						<tr>
							<th scope="row"><label for="last_name">Last Name : </label></th>
							<td><input type="text" name="last_name" value="<?php echo $current_user->user_lastname;?>" style="width:100%;"></td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php _e('Subscribe', 'subscribe_api' ) ?>" />
				</p>
				<p style="font-weight:bold;">Important! Username and password will be sent to you're email address you provide, please check your email inbox or in spam</p>
			</form>
		</div>
		<div class="col">
			<?php if( !$key && !$token ){?>
				<h3>Or if you already have API keys, fill up the fields below</h3>
			<?php }else{ ?>
				<h3>To complete your installation, you need to choose default property status ( found in CRM > Tools and Setting > Manage Property Status Field ).</h3>
			<?php } ?>
			<?php require($credentials_form);?>
		</div>
	</div>
</div>

