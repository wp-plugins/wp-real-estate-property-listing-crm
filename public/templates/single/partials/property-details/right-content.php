<?php
	if( has_action('before_right_sidebar_content') ){
		do_action( 'before_right_sidebar_content' );
	}
?>

<div class="panel panel-default">
  <div class="panel-body">
	<?php \Action_Buttons::get_instance()->display($additional_atts['args_button_action']); ?>
  </div>
</div>

<?php display_agent_details(get_single_data(), $atts); ?>

<?php
	\md_sc_single_properties::get_instance()->display_inquire_form($additional_atts['att_inquire_msg']);
?>

<div class="similar-homes">
	<h2><span>Similar Homes</span></h2>
	<?php md_display_nearby_property($atts); ?>
</div>

<?php \MD_Property_Content::get_instance()->displayTagContent(get_single_property_data()); ?>

<?php
	if( has_action('after_right_sidebar_content') ){
		do_action( 'after_right_sidebar_content' );
	}
?>
