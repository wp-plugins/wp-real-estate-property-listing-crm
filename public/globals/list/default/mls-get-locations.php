<?php if( $data_locations && count($data_locations) > 0 ){ ?>
<?php if( !has_filter('display_list_community_title') ){ ?>
	<h3 class="list-of-communities">List of Communities</h3>
<?php } ?>
<ul class="mls_child_list list-unstyled city-id-<?php echo $city_id;?> <?php echo $city_id;?>" >
	<?php foreach($data_locations as $key=>$val){ ?>
			<li><a href="<?php echo $val['url'];?>"><?php echo $val['name'];?></a></li>
	<?php } ?>
</ul>
<?php } ?>
