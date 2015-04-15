<?php
/**
 * Masterdigm Property Functions
 *
 * @author 		Allan / Masterdigm
 * @category 	Core
 * @package 	Masterdigm Property/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function md_global_carousel_template($atts){
	\MD_Template::get_instance()->get_carousel_template($atts);
}
function next_prev(){
	\Next_Prev::get_instance()->display();
}
