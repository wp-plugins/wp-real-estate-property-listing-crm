<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'plugins_loaded', 'init_cache' );
function init_cache(){
	\Masterdigm_Cache::get_instance()->md_wp_parse_query();
	\Masterdigm_Cache::get_instance()->init();
}
function cache_set($name, $value, $time = 300){
	return \Masterdigm_Cache::get_instance()->set($name, $value, $time);
}
function cache_get($name){
	return \Masterdigm_Cache::get_instance()->get($name);
}
function cache_del($name){
	return \Masterdigm_Cache::get_instance()->del($name);
}
function cache_clean(){
	return \Masterdigm_Cache::get_instance()->clean();
}
function cache_stats(){
	return \Masterdigm_Cache::get_instance()->stats();
}
