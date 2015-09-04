<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function set_agent_details($property_data){
	$agent 		= new MD_Agent;
	$agent->set_agent_data($property_data);
	$GLOBALS['agent'] = $agent->get_data();
}
function get_agent_name(){
	global $agent;
	return $agent->get_name();
}
function get_agent_email(){
	global $agent;
	return $agent->get_email();
}
function get_agent_phone(){
	global $agent;
	return $agent->get_phone();
}
function get_agent_mobile(){
	global $agent;
	return $agent->get_mobile_num();
}
function get_agent_photo(){
	global $agent;
	return $agent->get_photo();
}
