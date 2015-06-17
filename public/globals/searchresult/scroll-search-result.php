<?php if( have_properties() ){ ?>
	<div class="page-<?php echo $current_paged;?>">
		<?php foreach(have_properties() as $property ){ ?>
			<?php set_loop($property); ?>
			<?php
				$list_part = \MD_Template::get_instance()->load_template('list/default/part-list.php');
				require $list_part;
			?>
		<?php } ?>
		<div style="display:none !important;">
		<?php
			global $paged;
			$paged = $_POST['paged'];
			md_pagination('',2,get_ret_properties()->total);
		?>
		</div>
	</div>
<?php }else{//end if $properties ?>
		<div class="col-md-12 items">
			<input type="hidden" value="0" id="nomoredata">
		</div>
<?php }//end if $properties ?>
