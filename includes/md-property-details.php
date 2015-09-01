<?php
/**
 * Masterdigm Property Details Functions
 *
 * @author 		Allan / Masterdigm
 * @category 	Core
 * @package 	Masterdigm Property/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

#    Output easy-to-read numbers
#    by james at bandit.co.nz
function bd_nice_number($n) {
	// first strip any formatting;
	$n = (0+str_replace(",","",$n));

	// is this a number?
	if(!is_numeric($n)) return false;

	// now filter it;
	if($n>1000000000000) return round(($n/1000000000000),1).' T';
	else if($n>1000000000) return round(($n/1000000000),1).' B';
	else if($n>1000000) return round(($n/1000000),1).' M';
	else if($n>1000) return round(($n/1000),1).' K';

	return number_format($n);
}

function open_property_in($open = '_self'){
	if( get_current_view_query() == 'map' ){
		$open = '_blank';
	}
	return $open;
}
function get_property_details($property_id){
	return \MD_Single_Property::get_instance()->getSinglePropertyData($property_id);
}
