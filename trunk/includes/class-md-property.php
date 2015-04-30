<?php
namespace MD;
class Property{

	protected static $instance = null;
	public $loop;
	public $source;
	public $objProperty;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function set_properties($data, $source = null){
		if( is_null($source) ){
			$source = MD_DATA_FEED;
		}
		$this->setSource($source);
		$this->setObject($data);
	}

	public function setSource($source){
		$this->source = $source;
	}

	public function getSource(){
		return $this->source;
	}

	public function setObject($obj){
		$this->objProperty = $obj;
	}

	public function set_loop($loop){
		$this->loop = $loop;
	}

	public function get_loop(){
		return $this->loop;
	}

	public function getObject(){
		return $this->objProperty;
	}

	public function isCRM(){
		$source = $this->getSource();
		if( $source == 'crm' ) {
			return true;
		}
	}

	public function isMLS(){
		$source = $this->getSource();
		if( $source == 'mls' ) {
			return true;
		}
	}

	public function have_properties(){
		$properties = $this->getObject();
		if( isset($properties->total) && $properties->total > 0 || count($properties->data) > 0 ){
			return $properties->data;
		}elseif( !isset($properties->total) && count($properties) > 0 ){
			return $properties;
		}
		return false;
	}

	public function getFeed(){
		return $this->getSource();
	}

	public function displayUniqueID(){
		return $this->loop->displayUniqueID();
	}

	public function getID(){
		return $this->loop->getID();
	}

	/*
	 * Get single photo
	 * */
	public function objGetPhoto($array_key = 0){
		if( count($this->getPhotos()) > 0 ){
			if( $this->isCRM() ){
				$get_photo_url 	= $this->getObject()->getPhotoUrl($this->getPhotos());
				$img 			= $get_photo_url[$array_key];
			}elseif( $this->isMLS() ){
				$img =  $this->getPhotos()[$array_key];
			}
			return $this->getObject()->displayPrimaryPhotoUrl() ? $this->getObject()->displayPrimaryPhotoUrl():$img;
		}
	}

	public function getAddress(){
		return $this->loop->displayAddress();
	}

	public function getURL(){
		return $this->loop->displayUrl();
	}

	public function getPrice(){
		return $this->loop->displayPrice();
	}

	public function getBed(){
		return $this->loop->displayBed();
	}

	public function getBathroom(){
		return $this->loop->displayBathrooms();
	}

	public function getSqFt(){
		return $this->loop->displaySqFt();
	}

	public function getYearBuilt(){
		return $this->loop->displayYearBuilt();
	}

	public function getPhoto(){
		return $this->loop->displayPrimaryPhotoUrl();
	}

	public function hasPrimaryPhoto(){
		return $this->loop->hasPrimaryPhoto();
	}

	public function getTagLine(){
		if( $this->isCRM() ){
			return $this->loop->tag_line();
		}
		return '';
	}

	public function getTransaction(){
		return $this->loop->displayTransaction();
	}

	public function getGarage(){
		return $this->loop->displayGarage();
	}

	public function getArea(){
		return $this->loop->displaySqFt();
	}

	public function getAreaUnit($default){
		return $this->loop->displayAreaUnit($default);
	}

	public function getPropertyTitle(){
		return $this->getAddress();
	}

	public function getMLS(){
		return $this->loop->displayMLS();
	}

	public function getDescription(){
		return $this->loop->displayDescription();
	}

	public function getStatus(){
		return $this->loop->displayPropertyStatus();
	}

	public function getLat(){
		return $this->loop->getLattitude();
	}

	public function getLon(){
		return $this->loop->getLongitude();
	}
}
