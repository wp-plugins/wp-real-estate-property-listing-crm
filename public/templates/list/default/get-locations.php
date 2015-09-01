<?php if( $data_locations && count($data_locations) > 0 ){ ?>
<h3 class="list-of-communities">List of Communities</h3>
<ul class="crm_child_list list-unstyled">
	<?php foreach($data_locations as $key=>$val){ ?>
			<li><a href="<?php echo $val['url'];?>"><?php echo $val['name'];?></a></li>
	<?php } ?>
</ul>
<?php } ?>
