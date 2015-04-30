<?php
/*
Template Name: Search Result - Default Template
*/
?>
<div id="search-result-page">
	<?php
		$template_part = \MD_Template::get_instance()->load_template('list/default/list-default.php');
		if( $template_part ){
			require $template_part;
		}
	?>
</div>
