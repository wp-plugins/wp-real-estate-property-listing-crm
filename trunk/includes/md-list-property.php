<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function set_page_list($items, $index){

	if( $items >= $index ){
		return true;
	}
	return false;
}
