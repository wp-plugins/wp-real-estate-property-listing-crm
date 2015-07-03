<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function gmap_geocode($address){
	$latlon = \helpers\GMap::getLocation($address);
	return $latlon;
}
function get_ret_properties(){
	return \MD\Property::get_instance()->getObject();
}
function have_properties(){
	$properties = get_ret_properties();
	if( isset($properties->data) ){
		if( isset($properties->total) && $properties->total > 0 || count($properties->data) > 0 ){
			return $properties->data;
		}
	}elseif( !isset($properties->total) && count($properties) > 0 ){
		return $properties;
	}
	return false;
}
function have_photos(){
	$properties = \MD\Property::get_instance()->getObject();
	if( isset($properties->photo) ){
		return $properties->photo;
	}elseif(isset($properties->photo_url)){
		return $properties->photo_url;
	}
	return false;
}
function is_property_viewable($current_status){
	return apply_filters('is_property_viewable_hook_'.md_get_source(), $current_status);
}
function set_loop($property_loop){
	\MD\Property::get_instance()->set_loop($property_loop);
}
function md_property_id(){
	return \MD\Property::get_instance()->getID();
}
function md_property_address($type = 'long'){
	return \MD\Property::get_instance()->getAddress($type);
}
function md_property_url(){
	return \MD\Property::get_instance()->getURL();
}
function md_property_beds(){
	return \MD\Property::get_instance()->getBed();
}
function md_property_bathrooms(){
	return \MD\Property::get_instance()->getBathroom();
}
function md_property_yr_built(){
	return \MD\Property::get_instance()->getYearBuilt();
}
function md_property_price(){
	return \MD\Property::get_instance()->getPrice();
}
function md_property_raw_price(){
	return \MD\Property::get_instance()->getRawPrice();
}
function md_property_format_price(){
	$account  = \CRM_Account::get_instance()->get_account_data();
	$get_currency = ($account->currency) ? $account->currency:'$';
	return $get_currency.number_format( md_property_raw_price() );
}
function md_property_html_price(){
	$price = '';
	$account  = \CRM_Account::get_instance()->get_account_data();
	$get_currency = ($account->currency) ? $account->currency:'$';
	if( md_property_raw_price() == 0 ){
		$price = 'Call for pricing ';
		$price .= '<span>'.$account->work_phone.'</span>';
	}else{
		$price = $get_currency.number_format( md_property_raw_price() );
		$price .= '<span>&nbsp;</span>';
	}
	return $price;
}
function md_property_img($property_id = null){
	if( \MD\Property::get_instance()->getPhoto() ){
		return \MD\Property::get_instance()->getPhoto();
	}elseif(crm_md_get_featured_img($property_id)){
		return crm_md_get_featured_img($property_id);
	}
	return PLUGIN_ASSET_URL . 'house.png';
}
function md_property_has_img(){
	return \MD\Property::get_instance()->hasPrimaryPhoto();
}
function md_property_tagline(){
	return \MD\Property::get_instance()->getTagLine();
}
function md_property_garage(){
	return \MD\Property::get_instance()->getGarage();
}
function md_property_transaction(){
	return \MD\Property::get_instance()->getTransaction();
}
function md_property_area(){
	return \MD\Property::get_instance()->getArea();
}
function md_property_area_unit($default = 'account'){
	return ucwords(\MD\Property::get_instance()->getAreaUnit($default));
}
function md_property_title(){
	return \MD\Property::get_instance()->getPropertyTitle();
}
function md_get_source(){
	return \MD\Property::get_instance()->getSource();
}
function md_get_mls(){
	return \MD\Property::get_instance()->getMLS();
}
function md_get_description(){
	return \MD\Property::get_instance()->getDescription();
}
function md_get_property_url(){
	return \MD\Property::get_instance()->getURL();
}
function md_get_property_status(){
	return \MD\Property::get_instance()->getStatus();
}
function md_get_lat(){
	return \MD\Property::get_instance()->getLat();
}
function md_get_lon(){
	return \MD\Property::get_instance()->getLon();
}
function md_get_lat_gmap($address){
	if( md_get_lat() == 0 || md_get_lat() == '' ){
		$coordinate_gmap = gmap_geocode($address);
		return $coordinate_gmap['lat'];
	}else{
		return md_get_lat();
	}
}
function md_get_lng_gmap($address){
	if( md_get_lon() == 0 || md_get_lon() == '' ){
		$coordinate_gmap = gmap_geocode($address);
		return $coordinate_gmap['lng'];
	}else{
		return md_get_lon();
	}
}
function crm_md_get_featured_img($property_id){
	$properties_photos = have_photos();
	if( $properties_photos ){
		return \MD_Template::get_instance()->get_featured_img($properties_photos, $property_id);
	}
	return false;
}
