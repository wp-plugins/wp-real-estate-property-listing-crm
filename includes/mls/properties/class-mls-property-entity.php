<?php
namespace mls;
/**
 * Handle logic for fetching properties
 * */
class Property_Entity{

	protected static $instance = null;

	public function __construct(){

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Bind a Property taken from API to this object
	 */
	public function bind( $property )
	{
		foreach( get_object_vars( $property )  as $k => $v ){
			$this->$k = $v;
		}

		return $this;
	}

	public function displayAddressStateZip(){
		$state = strlen( $this->State ) == 2 ? strtoupper( $this->State ) : $this->State;
		return $state.' '.$this->ZipCode;
	}

	/**
	 * @param string $type
	 * 		- type can be long or short. Long address has zip on it
	 * return string
	 */
	public function displayAddress( $type = 'long')
	{

		$state 			= strlen( $this->State ) == 2 ? strtoupper( $this->State ) : $this->State;
		$street_suffix	= strlen( $this->StreetSuffix ) < 3 ? strtoupper( $this->StreetSuffix ) : $this->StreetSuffix;
		$street_name 	= ucwords( strtolower( $this->StreetName ) ).' '.$street_suffix;

		switch( $type ){
			default:
			case 'long':
				$address = $this->StreetNumber.' '.$street_name.' '.$this->City.', '.$state.' '.$this->PostalCode;
			break;
			case 'short':
				$address = $this->StreetNumber.' '.$street_name.' '.$this->City;
			break;
		}

		return \helpers\Text::remove_non_alphanumeric($address);

	}

	/**
	 * return string
	 */
	public function displayUrl()
	{
		// enable popup for un-registered user
		$address 			= str_replace(' ','-',$this->displayAddress());
		$second_uri 		= $address;
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->ListingId.'-'.$second_uri ) );
		$url 				= \Property_URL::get_instance()->get_property_url($urlencoded_address);
		return $url;
	}

	/**
	 * Use for getAccountCoverage method
	 * return string
	 */
	public function displayForSaleUrl( $type = 'long')
	{
		$with_zip =  $type == 'long' ? '-'.$this->zip : '';
		$coverage_address = str_replace(' ','-',$this->City).'-'.$this->State.$with_zip;
		return 'for-sale/'.$coverage_address;
	}

	/**
	 * @param string $type
	 * 	 - type can be high_res( high resolution ) or low_res( low resolution ). Long address has zip on it
	 * return string
	 */
	public function displayPrimaryPhotoUrl( $type = 'low_res', $property_photos = null )
	{
		if( !is_null($property_photos) ){
			$url = $property_photos;
		}else{
			if( ! isset( $this->PrimaryPhotoUrl ) || ! $this->PrimaryPhotoUrl ){
				return PLUGIN_ASSET_URL . 'house.png';
			}
			$url = substr( $this->PrimaryPhotoUrl , 0 ,4 ) == 'http' ? $this->PrimaryPhotoUrl : 'http://www.masterdigmserver1.com/'.$this->PrimaryPhotoUrl;
		}
		return $url;
	}

	public function hasPrimaryPhoto(){
		if( !isset( $this->PrimaryPhotoUrl ) || !$this->PrimaryPhotoUrl ){
			return false;
		}
		return true;
	}

	/**
	 * @param integer $word_limit
	 * return string
	 */
	public function displayDescription( $word_limit = 0 )
	{

		if( $word_limit ){
			return 	\helpers\Text::limit_words( $this->Description , $word_limit );
		}

		return $this->Description;
	}

	/**
	 * @param string $type
	 * return string
	 */
	public function displaySubtype()
	{
		return '';
	}

	/**
	 * @param string $type
	 * return string
	 */
	public function displayPrice()
	{
		$currency = \CRM_Account::get_instance()->get_account_data('currency');
		$get_currency = ($currency) ? $currency:'$';
		if( $this->ListPrice == 0 ){
			return 'Call for pricing';
		}else{
			return $get_currency.number_format( $this->ListPrice );
		}
	}

	public function get_price(){
		return $this->ListPrice;
	}

	/**
	 * @param string $type
	 * return string
	 */
	public function displayBathsTotal()
	{
		return number_format( $this->Baths );
	}

	/**
	 * Display if transaction is sale or rent
	 * @param string $type
	 * return string
	 */
	public function displayTransaction()
	{

		return $this->Transaction;
	}

	/*
	 * Use for check if the property status is 'Active' , 'Backup Offer' , 'Pending Sale'
	 * return boolean
	 * */
	public function displayProperty()
	{
		$status = array( 'Active' , 'Backup Offer' , 'Pending Sale' );

		if( in_array($this->Status, $status) ){
			return true;
		}
	}

	public function __get( $argument )
	{
		return NULL;
	}

	public function displayParams($val = null){
		$param = unserialize($this->params);
		if( $param[$val] ) {
			return $param[$val];
		}else{
			return false;
		}
	}

	public function displayBed(){
		return $this->Bedrooms;
	}

	public function displayBathrooms(){
		return $this->Baths;
	}

	public function getBathroom(){
		return $this->displayBathrooms();
	}

	public function getBed(){
		return $this->displayBed();
	}

	public function getMLS(){
		return $this->displayMLS();
	}

	public function get_floor_area(){
		return ($this->FloorArea != '') ? number_format($this->FloorArea):0;
	}

	public function get_lot_area(){
		return ($this->LotArea != '') ? number_format($this->LotArea):0;
	}

	public function get_sqft_heated(){
		return isset($this->FloorArea) ? number_format($this->FloorArea) : 0;
	}

	public function displaySqFt(){
		if( $this->FloorArea == 0 ){
			return $this->LotArea;
		}else{
			return $this->FloorArea;
		}
	}

	public function displayAreaMeasurement($type){
		$area = '';
		$measure_area = $this->displaySqFt();
		$array_measure = array();
		$unit_area = \CRM_Account::get_instance()->get_account_data('unit_area');
		$by = ($this->FloorArea == 0) ? 'lot':'floor';
		switch($type){
			case 'floor':
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$type,
					'raw_measure'	=>	$this->FloorArea,
					'measure'		=>	number_format($this->FloorArea)
				);
			break;
			case 'lot':
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$type,
					'raw_measure'	=>	$this->LotArea,
					'measure'		=>	number_format($this->LotArea)
				);
			break;
			default:
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$by,
					'raw_measure'	=>	$measure_area,
					'measure'		=>	number_format($measure_area)
				);
			break;
		}

		return (object)$array_measure;
	}

	public function displayAreaUnit( $type = 'account' ){
		$unit = '';
		$unit_area = \CRM_Account::get_instance()->get_account_data('unit_area');

		switch($type){
			case 'floor':
				$unit = $this->floor_area_unit;
			break;
			case 'lot':
				$unit = $this->lot_area_unit;
			break;
			case 'account':
				$unit = $unit_area;
			break;
		}
		return $unit;
	}

	public function displayYearBuilt(){
		return $this->YearBuilt;
	}

	public function displayMLS(){
		return $this->MLSID ? $this->MLSID:$this->ListingId;
	}

	public function displayPropertyStatus(){
		return $this->Status;
	}

	public function displayPropertyType(){
		return $this->PropertySubType;
	}

	public function getID(){
		return $this->ListingId;
	}

	public function getLattitude(){
		return $this->Latitude;
	}

	public function getLongitude(){
		return $this->Longitude;
	}

	public function get_county_name(){
		return $this->County;
	}

	public function get_city(){
		return $this->City;
	}

	public function get_city_name(){
		return $this->City;
	}

	public function get_state_name(){
		return $this->State;
	}

	public function get_property_id(){
		return $this->Propertyid;
	}

	public function get_listing_id(){
		return $this->Propertyid;
	}

	public function display_garage(){
		return $this->Garage;
	}

	public function display_air_conditioning(){
		return $this->Airconditioning;
	}

	public function display_heat_air_conditioning(){
		return $this->Airconditioning;
	}

	public function display_appliances_included(){
		return $this->Appliances;
	}

	public function display_architectural_style(){
		return $this->ArchitecturalStyle;
	}

	public function display_association_fee_includes(){
		return $this->AssociationFeeIncludes;
	}

	public function display_bath_full(){
		return $this->Baths;
	}

	public function display_bath_half(){
		return $this->BathsHalf;
	}

	public function display_bed_total(){
		return $this->Bedrooms;
	}

	public function display_close_date(){
		return $this->CloseDate;
	}

	public function display_close_price(){
		return $this->ClosePrice;
	}

	public function display_community_features(){
		return $this->CommunityFeatures;
	}

	public function display_county_or_parish(){
		return $this->County;
	}

	public function display_current_price(){
		return $this->ListPrice;
	}

	public function display_elem_school(){
		return $this->ElementarySchool;
	}

	public function display_exterior_construction(){
		return $this->Construction;
	}

	public function display_exterior_features(){
		return $this->ExteriorFeatures;
	}

	public function display_fences(){
		return $this->Fences;
	}

	public function display_fireplace_yn(){
		return $this->Fireplace;
	}

	public function display_floor_covering(){
		return $this->Flooring;
	}

	public function display_foundation(){
		return $this->Foundation;
	}

	public function displayGarage(){
		return $this->Garage;
	}

	public function display_garage_carport(){
		return $this->Garage;
	}

	public function display_garage_features(){
		return $this->GarageFeatures;
	}

	public function display_heating_fuel(){
		return $this->Heating;
	}

	public function display_high_school(){
		return $this->HighSchool;
	}

	public function display_housing_for_older_person(){
		return $this->HousingForOlderPersons;
	}

	public function display_interior_features(){
		return $this->InteriorFeatures;
	}

	public function display_interior_layout(){
		return $this->InteriorLayout;
	}

	public function display_kitchen_features(){
		return $this->KitchenFeatures;
	}

	public function community(){
		if( isset($this->Community) ){
			return $this->Community;
		}else{
			return $this->Subdivision;
		}
	}

	public function display_legal_subdivision_name(){
		return $this->LegalSubdivisionName;
	}

	public function display_list_office_name(){
		return $this->ListingOffice;
	}

	public function display_lot_size_acres(){
		return isset($this->LotSizeAcres) ? $this->LotSizeAcres : $this->Area;
	}

	public function display_lot_size_sqft(){
		return $this->LotArea;
	}

	public function display_maintenance_includes(){
		return $this->MaintenanceIncludes;
	}

	public function display_middleor_junior_school(){
		return $this->MiddleorJuniorSchool;
	}

	public function display_mls_number(){
		return $this->MLSID;
	}

	public function display_pool(){
		return $this->Pool;
	}

	public function display_pool_type(){
		return $this->PoolType;
	}

	public function display_postal_code(){
		return $this->PostalCode;
	}

	public function display_property_type(){
		if( isset($this->PropertyTypeNumber) ){
			return \mls\AccountEntity::get_instance()->get_property_type_key($this->PropertyTypeNumber);
		}else{
			return $this->Type;
		}
	}

	public function display_public_remarks_new(){
		return $this->PublicRemarksNew;
	}

	public function display_roof(){
		return $this->Roof;
	}

	public function display_sqft_heated(){
		return $this->FloorArea;
	}

	public function display_sqft_total(){
		return $this->SqFtTotal;
	}

	public function display_state_or_province(){
		return $this->State;
	}

	public function display_status(){
		return $this->Status;
	}

	public function display_street_city(){
		return $this->StreetCity;
	}

	public function display_tax_year(){
		return $this->TaxYear;
	}

	public function display_taxes(){
		$currency 		= \CRM_Account::get_instance()->get_account_data('currency');
		$get_currency 	= ($currency) ? $currency:'$';
		$taxes = 0;
		if( isset($this->Tax) ){
			$taxes = $this->Tax;
		}
		return $get_currency.number_format( $taxes );
	}

	public function display_total_acreage(){
		return $this->TotalAcreage;
	}

	public function display_utilities(){
		return $this->Utilities;
	}

	public function display_virtual_tour_link(){
		return $this->VirtualTourLink;
	}

	public function display_virtual_tour_link2(){
		return $this->VirtualTourURL2;
	}

	public function display_water_frontage(){
		return $this->WaterFrontage;
	}

	public function display_water_frontage_yn(){
		return $this->WaterFrontageYN;
	}

	public function legal_subdivision_name(){
		return isset($this->LegalSubdivisionName) ? $this->LegalSubdivisionName : $this->Subdivision;
	}

	public function hoa(){
		if( isset($this->HOA) ){
			return $this->HOA == 0 ? 'Yes':'No';
		}elseif( isset($this->HOACommonAssn) ){
			return $this->HOACommonAssn == 'Required' ? 'Yes':'No';
		}
	}

	public function display_listing_office(){
		return $this->ListingOffice;
	}

	public function time_stamp_modified(){
		return $this->TimeStampModified;
	}

	public function listing_agent_full_name(){
		return $this->ListingAgentFullName;
	}

	public function getPhotoUrl($array, $key = 0, $object = 'url'){
		$data = array();
		if( $array && is_array($array) && count($array) > 0 ){
			if( isset($array[$key]->$object) ){
				$data[] = $array[$key]->$object;
			}
			return $data;
		}else{
			return array();
		}

	}
}
