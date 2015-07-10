<ul class="list-inline" id="photos-single-container">
	<?php if( count(get_single_property_photos()) > 0 ){ ?>
		<?php foreach(get_single_property_photos() as $key => $val ){ ?>
			<li class="col-xs-6 col-md-4 photos-item-single">
				<a href="<?php echo $val;?>" class="thumbnail thickbox" rel="gallery-photos">
					<img class="img-responsive" src="<?php echo $val;?>">
				</a>
			</li>
		<?php } ?>
	<?php } ?>
</ul>
