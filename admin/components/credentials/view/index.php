<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<?php if(\API_Credentials::get_instance()->getError()){ ?>
		<div class="error">
			<ul>
				<?php foreach(\API_Credentials::get_instance()->getError() as $val) { ?>
						<li><p class="error"><?php echo $val;?></p></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<form name="md_api" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', 'update_api' ) ?>" />
        <input type="hidden" name="action" value="update_api">
		<h4>Please Choose which default data to feed</h4>
		<select name="property_data_feed">
			<option value="0">Select Data Feed</option>
			<option value="crm" <?php echo (get_option( 'property_data_feed' ) == 'crm') ? 'selected':''; ?>>CRM</option>
			<option value="mls" <?php echo (get_option( 'property_data_feed' ) == 'mls') ? 'selected':''; ?>>MLS</option>
		</select>
        <hr />

        <h4>Masterdigm CRM - API</h4>
        <p><?php _e("API KEY: " ); ?><input type="text" name="api_key" value="<?php echo get_option( 'api_key' );?>" style="width:50%;"></p>
        <p><?php _e("API TOKEN: " ); ?><input type="text" name="api_token" value="<?php echo get_option( 'api_token' );?>" style="width:50%;"></p>
        <p><?php _e("Broker ID: " ); ?><input type="text" name="broker_id" value="<?php echo get_option( 'broker_id' );?>" style="width:50%;"></p>
        <p><?php _e("User ID: " ); ?><input type="text" name="user_id" value="<?php echo get_option( 'user_id' );?>" style="width:50%;"></p>

        <h4>Masterdigm MLS - API</h4>
        <p><?php _e("API KEY: " ); ?><input type="text" name="mls_api_key" value="<?php echo get_option( 'mls_api_key' );?>" style="width:50%;"></p>
        <p><?php _e("API TOKEN: " ); ?><input type="text" name="mls_api_token" value="<?php echo get_option( 'mls_api_token' );?>" style="width:50%;"></p>

        <p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', 'update_api' ) ?>" />
        </p>
    </form>

</div>

