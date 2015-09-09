<div class="content-help">
	<p></p>
</div>
<h2>
	Update breadcrumb filter
</h2>
<form id="post" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" name="post">
<input type="hidden" name="action" value="post_update">
<?php if(\Breadcrumb_Url::get_instance()->getError()){ ?>
		<div class="error">
			<ul>
				<?php foreach(\Breadcrumb_Url::get_instance()->getError() as $val) { ?>
						<li><p class="error"><?php echo $val;?></p></li>
				<?php } ?>
			</ul>
		</div>
<?php } ?>
<div>
	<p>Filter the location name to replace URl</p>
	<input type="textbox" name="filter_name" value="<?php echo $get_filter->filter_name;?>">
</div>

<?php if( isCRM() ){ ?>
<div>
	<p>For CRM you need to provide location ID</p>
	<input type="textbox" name="filter_location_id" value="<?php echo $get_filter->location_id;?>">
</div>
<?php } ?>
<div>
	<p>In order to know what type of location , please choose location to search</p>
	<?php if( count($choose_location_to_search) > 0 ){ ?>
			<select name="filter_location_search">
			<?php foreach($choose_location_to_search as $key=>$val){ ?>
				<option value="<?php echo $key;?>" <?php echo ($get_filter->filter_location_search == $key ) ? 'selected':'';?>><?php echo $val;?></option>
			<?php } ?>
			</select>
	<?php } ?>
</div>
<div>
	<p>Choose page to replace URL</p>
	<?php if( count($posts_array) > 0 ){ ?>
		<select name="select_page">
			<?php foreach($posts_array as $key=>$val) { ?>
					<option value="<?php echo $val->ID; ?>" <?php echo ($id == $val->ID ) ? 'selected':'';?>>
						<?php echo $val->post_title; ?>
					</option>
			<?php } ?>
		</select>
	<?php } ?>
</div>
<p><button type="submit" name="update">Update Filter</button></p>
</form>
