<div class="panel panel-default" id="panel-single-property">
  <div class="panel-body">
  </div>
</div>
<div class="list-properties-container well">
	<?php if( get_total_properties() > 0 ){//if get_total_properties?>
		<?php $col = 12; ?>
		<ul class="list-group list-group-properties">
		<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
			<?php set_loop($property); ?>
			<li class="<?php echo md_property_id();?>-sidebar property-list" data-property-id="<?php echo md_property_id();?>" id="<?php echo md_property_id();?>">
				<?php
					$list_part = \MD_Template::get_instance()->load_template('list/default/part-list-property.php');
					require $list_part;
				?>
			</li>
		<?php }//loop end have_properties() ?>
		</ul>
		<script>
			var property_data 		= <?php echo json_encode($this->properties_data());?>;
			var total_properties 	= <?php echo get_total_properties();?>;
		</script>
	<?php }//if get_total_properties?>
</div>
