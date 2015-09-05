<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<div class="content-help">
	<p></p>
	</div>
	<form id="post" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" name="post">
		<input type="hidden" name="action" value="update_api">
		<?php if($obj_admin_util->getError()){ ?>
			<ul>
				<?php foreach($obj_admin_util->getError() as $val) { ?>
						<li><p class="error"><?php echo $val;?></p></li>
				<?php } ?>
			</ul>
		<?php } ?>
		<div id="tabs">
		  <ul>
			<li><a href="#tabs-popup">Popup</a></li>
			<li><a href="#tabs-property">Property</a></li>
			<li><a href="#tabs-search-result">Search Result</a></li>
			<li><a href="#tabs-mail">Mail</a></li>
		  </ul>
		  <div id="tabs-popup">
				<div class="show-pop-up">
					<h3>Show pop-up on certain clicks?</h3>
					<p>
						How this works? when a visitor visit your website, if 'turn on' it will display after certain click of property pages
						these are the individual property page. The popup will force the visitor to register to continue browsing.
					</p>
					<select name="setting[showpopup][show]">
						<?php foreach($show_popup_choose as $key=>$val){ ?>
								<option value="<?php echo $key;?>" <?php echo ($obj->showpopup_settings('show') == $key) ? 'selected':'';?>><?php echo $val;?></option>
						<?php } ?>
					</select>
					<p>
						Display close button? do you want the ability to close the popup?
					</p>
					<select name="setting[showpopup][close]">
						<?php foreach($show_popup_close_button as $key=>$val){ ?>
								<option value="<?php echo $key;?>" <?php echo ($obj->showpopup_settings('close') == $key) ? 'selected':'';?>><?php echo $val;?></option>
						<?php } ?>
					</select>
					<p>
						Show popup after certain clicks. This will show popup after certain click or view of individual property
					</p>
					<select name="setting[showpopup][clicks]">
						<?php foreach($show_popup_after as $key=>$val){ ?>
								<option value="<?php echo $key;?>" <?php echo ( $default_click == $key ) ? 'selected':'';?>><?php echo $val;?></option>
						<?php } ?>
					</select>
				</div>
		  </div>
		  <div id="tabs-property">
			<div class="js-system">
				<p>Enable Masonry? <input type="checkbox" name="setting[js][masonry]" <?php echo $obj->getSettingsGeneralByKey('js','masonry') ? 'checked':'';?>></p>
				<p>Default Column Grid <input type="text" name="setting[template][colgrid]" value="<?php echo $obj->getSettingsGeneralByKey('template','colgrid') ? $obj->getSettingsGeneralByKey('template','colgrid'):3;?>"></p>
			</div>
			<div class="property">
				<h3>Property</h3>
				<p>Search property by default search criteria, Default status, when visitor search property, they will see this search criteria status</p>
				<select name="setting[search_criteria][status]">
					<?php foreach($search_status as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php echo ( $obj->getSettingsGeneralByKey('search_criteria','status') == $key ) ? 'selected':'';?>><?php echo $val;?></option>
					<?php } ?>
				</select>
				<p>Display property address or tag-line</p>
				<select name="setting[property][name]">
					<?php foreach($show_default_property_name as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php echo ( \Settings_API::get_instance()->getSettingsGeneralByKey('property','name') == $key ) ? 'selected':'';?>><?php echo $val;?></option>
					<?php } ?>
				</select>
			</div>
		  </div>
		  <div id="tabs-search-result">
			<div class="search-result">
				<h3>Search Result</h3>
				<p>Display view </p>
				<select name="setting[view][type]">
					<?php foreach($view_options as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php echo ( \Settings_API::get_instance()->getSettingsGeneralByKey('view','type') == $key ) ? 'selected':'';?>><?php echo $val;?></option>
					<?php } ?>
				</select>
			</div>
		  </div>
		  <div id="tabs-mail">
			<div class="mail-system">
				<h3>Mail</h3>
				<p>(outgoing email) Use this mail system to send email from mail server</p>
				<input type="text" style="width:30%;" name="setting[mail][server]" value="<?php echo $obj->getSettingsGeneralByKey('mail','server');?>">
			</div>
		  </div>
		</div>
		<p><button type="submit" name="update_api">Update</button></p>
	</form>
</div>
<script>
jQuery(function() {
jQuery( "#tabs" ).tabs();
});
</script>
