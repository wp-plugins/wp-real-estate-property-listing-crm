<div class="content-help">
	<p></p>
</div>
<h2>
	Add new content to tag in property.
</h2>
<form id="post" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" name="post">
	<input type="hidden" name="action" value="post_add_new">
	<div class="error">
		<?php if($obj->getError()){ ?>
			<ul>
				<?php foreach($obj->getError() as $val) { ?>
						<li><p class="error"><?php echo $val;?></p></li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
	<div>
		<p>Choose what property you want to associate with content, single property / location (city, state or cummunity )</p>
		<?php if( count($property_type) > 0 ) { ?>
			<select name="property_type">
				<?php foreach($property_type as $key=>$val){ ?>
						<option value="<?php echo $key;?>">
							<?php echo $val; ?>
						</option>
				<?php } ?>
			</select>
		<?php } ?>
	</div>
	<div>
		<p>Provide URL if you choose single property, else ID or location name if you choose locations</p>
		<input type="text" name="property_data" style="width:50%;">
	</div>
	<div>
		<p>Choose which page to associate with the property, To select multiple content, hold down shift and choose any content</p>
		<?php if( count($content) > 0 ) { ?>
			<select name="choose_content[]" size="10" multiple>
				<?php foreach($content as $list){ ?>
						<option value="<?php echo $list->ID;?>">
							<?php echo $list->post_title; ?>
						</option>
				<?php } ?>
			</select>
		<?php } ?>
	</div>
	<div>
		<p>
			<input type="checkbox" name="display_featured_img">
			Display featured image on the choosen content?
		</p>
	</div>
	<div>
		<p>
			Choose how to display the content list
		</p>
		<select name="display_content_list">
			<?php foreach($content_list_display as $key => $content_list){ ?>
					<option value="<?php echo $key; ?>">
						<?php echo $content_list;?>
					</option>
			<?php } ?>
		</select>
	</div>
	<div>
		<p>Choose category to associate</p>
		<?php if( count($categories) > 0 ){ ?>
			<select name="choose_category[]" size="10" multiple>
				<?php foreach($categories as $key_cat => $val_cat) { ?>
						<option value="<?php echo $val_cat->term_id;?>">
							<?php echo $val_cat->name; ?>
						</option>
				<?php } ?>
			</select>
		<?php } ?>
	</div>
	<div>
		<p>
			<input type="checkbox" name="display_category_featured_img">
			Display category, content featured image?
		</p>
	</div>
	<div>
		<p>
			Choose how to display the category content list
		</p>
		<select name="display_category_list">
			<?php foreach($cat_content_list_display as $key => $content_list){ ?>
					<option value="<?php echo $key; ?>">
						<?php echo $content_list;?>
					</option>
			<?php } ?>
		</select>
	</div>
	<p><button type="submit" name="add">Add Tag Content</button></p>
</form>
