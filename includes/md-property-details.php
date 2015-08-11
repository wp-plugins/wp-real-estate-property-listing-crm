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
