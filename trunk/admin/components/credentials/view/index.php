<div class="wrap about-wrap">
	<h1>Welcome to <?php echo esc_html( get_admin_page_title() ); ?> <?php echo \Masterdigm_API::get_instance()->get_version();?></h1>
	<?php if(\API_Credentials::get_instance()->getError()){ ?>
		<div class="error">
			<ul>
				<?php foreach(\API_Credentials::get_instance()->getError() as $val) { ?>
						<li><p class="error"><?php echo $val;?></p></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>

	<?php require_once($notice); ?>

	<form name="md_api" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="action" value="update_api">

		<div class="search-data">
			<h4>Search Property, Choose which default data to get properties feed, mostly the default is CRM ( unless masterdigm setup a MLS data on your account )</h4>
			<select name="property_data_feed">
				<option value="0">Select Data Feed</option>
				<option value="crm" <?php echo (get_option( 'property_data_feed' ) == 'crm') ? 'selected':''; ?>>CRM</option>
				<option value="mls" <?php echo (get_option( 'property_data_feed' ) == 'mls') ? 'selected':''; ?>>MLS</option>
			</select>
			<hr />
		</div>

		<?php if( !$setting && get_option('md_not_finish_install') ){ ?>
				<div class="search-status">
					<h4>To complete your installation, you need to choose default property status ( found in CRM > Tools and Setting > Manage Property Status Field )</h4>
					<select name="setting[search_criteria][status]">
						<?php foreach($property_status as $key => $val){ ?>
								<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php } ?>
					</select>
					<hr />
				</div>
		<?php } ?>

		<?php
			if( get_option('md_finish_install') ){
				$log = \Create_Location_Page::get_instance()->get_option_log();

				if( !$log && count($log) == 0 ){
					echo '<h2>Create page by location now, <a href='.admin_url('admin.php?page=md-api-create-page-location').'>Click this link</a></h2>';
				}
			}
		?>

        <h4>Masterdigm CRM - API</h4>
        <p><?php _e("API KEY: " ); ?><input type="text" name="api_key" value="<?php echo get_option( 'api_key' );?>" style="width:50%;"></p>
        <p><?php _e("API TOKEN: " ); ?><input type="text" name="api_token" value="<?php echo get_option( 'api_token' );?>" style="width:50%;"></p>
        <p><?php _e("Broker ID: " ); ?><input type="text" name="broker_id" value="<?php echo get_option( 'broker_id' );?>" style="width:50%;"></p>

        <p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', 'update_api' ) ?>" />
        </p>
    </form>
</div>

