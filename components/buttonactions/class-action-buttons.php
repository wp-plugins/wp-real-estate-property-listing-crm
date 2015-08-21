<?php
/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class Action_Buttons {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	private $plugin_name;
	private $version;
	public $button = array(
		'favorite',
		'xout',
		'share',
		'print',
	);

	public function __construct(){
		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
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

	public function enqueue_scripts(){
		wp_enqueue_script( $this->plugin_name . '-button-actions', plugin_dir_url( __FILE__ ) . 'js/buttonaction-min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Display the buttons
	 * @param	array	$array_buttons		Show button according to value.
	 * 										key 'show'
	 * 										if show = 1 display the button container
	 * 										Accepts :
	 * 										key 'favorite'
	 * 										array(
	 * 											'show'=>1,
	 * 											'label'=>'Favorite',
	 * 											'other' => array(
	 * 												'class'=>''
	 * 											)
	 * 										),
	 * 										key 'xout'
	 *
	 * @return
	 *
	 * */
	public function display($array_buttons){
		$buttons = '';

		foreach($array_buttons as $key => $val ){
			if( $key == 'favorite' ){
				$buttons .= $this->favorite_button($array_buttons['favorite']);
			}
			if( $key == 'xout' ){
				$buttons .= $this->xout_button($array_buttons['xout']);
			}
			if( $key == 'print' ){
				$buttons .= $this->print_button($array_buttons['print']);
			}
			if( $key == 'share' ){
				$buttons .= $this->share_button($array_buttons['share']);
			}
		}

		$show = 1;
		if( isset($array_buttons['show']) ){
			$show = $array_buttons['show'];
		}

		if( $show == 1 ){
			return $buttons;
		}
	}

	/**
	 * Show favorite button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function favorite_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = 'Favorite';
		}
		if( isset($args['show']) ){
			$show = $args['show'];
		}else{
			$show = 1;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'favorite-button';
		}

		if( isset($args['feed']) ){
			$feed = $args['feed'];
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$is_save = false;
		if( isset($args['is_save']) ){
			$is_save = true;
		}

		if( $show == 1 ){
			$action = 'saveproperty_action';
			$content = '<p>Must register or login to mark as favorite</p>';
			require 'view/favorite-button.php';
		}
	}

	/**
	 * Show X-Out button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function xout_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = 'X-Out';
		}
		if( isset($args['show']) ){
			$show = $args['show'];
		}else{
			$show = 1;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'xout-button';
		}

		if( isset($args['feed']) ){
			$feed = $args['feed'];
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$is_save = false;
		if( isset($args['is_save']) ){
			$is_save = true;
		}

		if( $show == 1 ){
			$action = 'xoutproperty_action';
			$content = '<p>Must register or login to mark as x-out</p>';
			require 'view/xout-button.php';
		}
	}

	/**
	 * Show Print button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function print_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = 'Print PDF';
		}
		if( isset($args['show']) ){
			$show = $args['show'];
		}else{
			$show = 1;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'print-button';
		}

		if( isset($args['url']) ){
			$url = $args['url'];
		}else{
			$url = '';
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		if( $show == 1 ){
			require 'view/print-button.php';
		}
	}

	/**
	 * Share button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function share_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = 'Share';
		}
		if( isset($args['show']) ){
			$show = $args['show'];
		}else{
			$show = 1;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'share-button';
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$is_save = false;
		if( isset($args['is_save']) ){
			$is_save = true;
		}

		if( isset($args['url']) ){
			$url = $args['url'];
		}else{
			$url = '';
		}

		if( isset($args['address']) ){
			$address = $args['address'];
		}else{
			$address = '';
		}

		$photo = '';
		$photo = get_single_property_photos();
		$property = get_single_property_data();
		if( get_single_property_source() == 'crm' ){
			$photo_url = $property->getPhotoUrl($photo);
			if( isset($photo_url[0]) ){
				$photo = $photo_url[0];
			}
		}elseif(get_single_property_source() == 'mls' ){
			$photo = $property->PrimaryPhotoUrl;
		}else{
			if( is_array($photo) ){
				if( is_object($photo[0]) ){
					$photo = $photo[0]->url;
				}
			}
		}
		$media = $photo;

		if( $show == 1 ){
			require 'view/share-button.php';
		}
	}

	public static function display_sort_button($args = array()){
		$class_sort_container = '';
		if( isset($args['class_container']) ){
			$class_sort_container = $args['class_container'];
		}

		$class_button = '';
		if( isset($args['class_button']) ){
			$class_button = $args['class_button'];
		}

		$class_dropdown_ul = '';
		if( isset($args['class_dropdown_ul']) ){
			$class_dropdown_ul = $args['class_dropdown_ul'];
		}

		require 'view/sort.php';
	}
}
