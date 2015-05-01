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
				return $this->StreetNumber.' '.$street_name.' '.$this->City.', '.$state.' '.$this->ZipCode;
			break;
			case 'short':
				return $this->StreetNumber.' '.$street_name.' '.$this->City;
			break;
		}

	}

	/**
	 * return string
	 */
	public function displayUrl()
	{
		// enable popup for un-registered user
		$address 			= str_replace(' ','-',$this->displayAddress());
		$second_uri 		= $address;
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->Matrix_Unique_ID.'-'.$second_uri ) );
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
			return 	\helpers\Text::limit_words( $this->PropertyDescription , $word_limit );
		}

		return $this->PropertyDescription;
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
		$currency = \crm\AccountEntity::get_instance()->get_account_data('currency');
		$get_currency = ($currency) ? $currency:'$';
		if( $this->ListPrice == 0 ){
			return 'Call for pricing';
		}else{
			return $get_currency.number_format( $this->ListPrice );
		}
	}

	/**
	 * @param string $type
	 * return string
	 */
	public function displayBathsTotal()
	{
		return number_format( $this->BathsTotal );
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
		return $this->BathsFull;
	}

	public function displaySqFt(){
		return number_format($this->LotSquareFootage);
	}

	public function displayAreaMeasurement($type){
		$area = '';
		$measure_area = 0;
		$array_measure = array();
		$unit_area = \crm\AccountEntity::get_instance()->get_account_data('unit_area');
		switch($type){
			case 'floor':
				$array_measure = array(
					'area_type'=>$unit_area,
					'measure'=>number_format($this->floor_area)
				);
			break;
			case 'lot':
				$array_measure = array(
					'area_type'=>$unit_area,
					'measure'=>number_format($this->lot_area)
				);
			break;
			default:
			break;
		}
		return (object)$array_measure;
	}

	public function displayAreaUnit( $type = 'account' ){
		$unit = '';
		$unit_area = \crm\AccountEntity::get_instance()->get_account_data('unit_area');
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

	public function displayGarage(){
		return $this->garage ? $this->garage:0;
	}

	public function displayMLS(){
		return $this->MLnumber ? $this->MLnumber:'&nbsp;';
	}

	public function displayPropertyStatus(){
		return $this->Status;
	}

	public function displayPropertyType(){
		return $this->PropertySubType;
	}

	public function getID(){
		return $this->Matrix_Unique_ID;
	}

	public function getLattitude(){
		return $this->Latitude;
	}

	public function getLongitude(){
		return $this->Longitude;
	}
}
