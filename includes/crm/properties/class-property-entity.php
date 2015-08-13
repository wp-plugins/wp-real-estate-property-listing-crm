<?php
namespace crm;
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

	public function hasProperty( $name ) {
        return array_key_exists( $name, get_object_vars( $this ) );
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
	public function displayAddress($type = 'long')
	{
		switch( $type ){
			default:
			case 'long':
				$name = $this->community.' '.$this->address.', '.$this->city.', '.$this->state.', '.$this->zip;
			break;
			case 'short':
				$name = ($this->address != '') ? $this->address:$this->tag_line;
			break;
		}
		if( get_default_property_name() == 'tagline' ){
			$name = $this->tag_line;
		}
		return $name;
	}

	/**
	 * return string
	 */
	public function displayUrl()
	{
		// enable popup for un-registered user
		$address = str_replace(' ','-',$this->displayAddress());
		$tag_line = str_replace(' ','-',$this->tag_line);
		$second_uri = ($address == '') ? $tag_line:$address;
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->id.'-'.$second_uri ) );
		$url = \Property_URL::get_instance()->get_property_url($urlencoded_address);
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
		//return home_url('for-sale/'.$coverage_address);
	}

	/**
	 * @param string $type
	 * 	 - type can be high_res( high resolution ) or low_res( low resolution ).
	 * return string
	 */
	public function displayPrimaryPhotoUrl()
	{
		if( isset($this->photo_url) ){
			return $this->photo_url;
		}
		return false;
	}
	public function hasPrimaryPhoto(){
		if( isset($this->photo_url) ){
			return true;
		}
		return false;
	}
	/**
	 * @param integer $word_limit
	 * return string
	 */
	public function displayDescription( $word_limit = 0 )
	{
		if( $word_limit ){
			return 	\helpers\Text::limit_words( strip_tags($this->description) , $word_limit );
		}
		return $this->description;
	}

	public function cleanDescription( $word_limit = 0 ){

		if( $word_limit ){
			$desc = preg_replace('/(\s)+/', ' ', $this->description);
			$desc = ereg_replace("[^A-Za-z0-9]", "", $desc );
			$desc = strip_tags($desc);

			return \helpers\Text::limit_words( $desc , $word_limit );
		}
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
		$account  = \CRM_Account::get_instance()->get_account_data();
		$get_currency = ($account->currency) ? $account->currency:'$';
		if( $this->price == 0 ){
			$price = "Call for pricing ".$account->work_phone;
			return $price;
		}else{
			return $get_currency.number_format( $this->price );
		}
	}

	public function get_price(){
		return $this->price;
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
		return $this->transaction_type ? $this->transaction_type:false;
	}

	public function displayPropertyType(){
		$type = \CRM_Account::get_instance()->get_fields();
		if( $type->result == 'success' || $type->success ){
			$property_type = json_decode(json_encode($type->fields->types), true);
			if( isset($property_type[$this->property_type]) ){
				return $property_type[$this->property_type];
			}
		}
		return false;
	}

	public function displayPropertyStatus(){
		$status = \CRM_Account::get_instance()->get_fields();
		if( $status->result == 'success' || $status->success ){
			$property_status = json_decode(json_encode($status->fields->status), true);
			if( isset($property_status[$this->property_status]) ){
				return $property_status[$this->property_status];
			}
		}
		return false;
	}

	public function displayLotArea(){
		return number_format($this->lot_area);
	}

	public function displayAreaMeasurement($type){
		$area = '';
		$measure_area = 0;
		$array_measure = array();
		$unit_area = \CRM_Account::get_instance()->get_account_data('unit_area');
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
				if( $this->floor_area == 0 ){
					$array_measure = array(
						'area_type'=>$unit_area,
						'measure'=>number_format($this->lot_area)
					);
				}else{
					$array_measure = array(
						'area_type'=>$unit_area,
						'measure'=>number_format($this->floor_area)
					);
				}
			break;
		}
		return (object)$array_measure;
	}

	public function displayFloorArea(){
		return number_format($this->floor_area);
	}

	public function displayAreaUnit( $type = 'floor' ){
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

	public function displaySqFt(){
		return $this->displayFloorArea();
	}


	public function __get( $argument )
	{
		return NULL;
	}

	public function getMetaDescription(){
		$desc = trim(strip_tags($this->description));
		$price = 'Price : ' . $this->displayPrice();
		$bed = 'Bed : ' . $this->beds;
		$baths = 'Baths : ' . $this->baths;
		$floor_area = 'Floor Area : ' . $this->floor_area;
		$lot_area = 'Lot Area : ' . $this->lot_area;
		$year_built = 'Year built : ' . $this->year_built;
		$garage = 'Garage : ' . $this->garage;

		$property_meta = $desc . ' ' . $price . ' ' .
						 $bed . ' ' . $baths . ' ' . $floor_area . ' ' . $lot_area . ' ' .
						 $year_built. ' ' . $garage;

		return $property_meta;
	}

	public function getPhotoUrl($array){
		$convert_obj_array = json_decode(json_encode($array), true);
		if( $convert_obj_array ){
			return array_values($convert_obj_array);
		}else{
			return array();
		}
	}

	public function displayParams($val = null){
		/*$param = unserialize($this->params);
		if( isset($param[$val]) ) {
			return $param[$val];
		}*/
		return false;
	}

	public function displayBed(){
		return $this->beds;
	}

	public function displayBathroom(){
		return $this->baths;
	}

	public function displayYearBuilt(){
		return $this->year_built ? $this->year_built:'&nbsp;';
	}

	public function displayMLS(){
		return $this->mlsid ? $this->mlsid:$this->getID();
	}

	public function displayBathrooms(){
		return $this->baths;
	}

	public function displayBeds(){
		return $this->beds;
	}

	public function getBathroom(){
		return $this->displayBathrooms();
	}

	public function getMLS(){
		return $this->displayMLS();
	}

	public function getBed(){
		return $this->displayBeds();
	}

	public function displayGarage(){
		return $this->garage;
	}

	public function displayTagline(){
		return $this->tag_line;
	}

	public function displayPhoto(){
		return $this->photo;
	}

	public function displayImg(){
		if( $this->photo_url ){
			return $this->displayPrimaryPhotoUrl();
		}
		return false;
	}

	public function displayUniqueID(){
		return $this->id;
	}

	public function getID(){
		return $this->id;
	}

	public function getLattitude(){
		return $this->latitude;
	}

	public function getLongitude(){
		return $this->longitude;
	}

	public function get_city_name(){
		return $this->StreetCity;
	}

	public function debug(){
		echo '<pre>';
			echo 'country : '.$this->countryid.':'.$this->country.'<br>';
			echo 'county : '.$this->countyid.':'.$this->county.'<br>';
			echo 'state : '.$this->stateid.':'.$this->state.'<br>';
			echo 'city : '.$this->cityid.':'.$this->city.'<br>';
			echo 'community : '.$this->communityid.':'.$this->community.'<br>';
		echo '</pre>';
	}

	public function time_stamp_modified(){
		return false;
	}
}
