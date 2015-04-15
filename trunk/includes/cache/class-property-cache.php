<?php
/**
 * Use for the property cache class
 * */
class Property_Cache {

	protected static $instance = null;

	public function __construct(){
		$this->arr_pre_define_cache_keyword = array(
			'featured' 	=> array(
				'id'=>'property-featured',
				'label' => 'Featured Property'
			),
			'search' => array(
				'id'=>'property-search',
				'label' => 'Search or List Property'
			),
			'search_autocomplete' => array(
				'id'=>'search-autocomplete',
				'label' => 'Autocomplete Search'
			),
			'account_coverage' => array(
				'id'=>'cache-account-coverage',
				'label' => 'Cache Account Coverage'
			),
			'navigation_property' => array(
				'id'=>'cache-navigation-property',
				'label' => 'Cache Navigation Properties'
			),
			'next_prev_keyword' => array(
				'id'=>'cache-next-prev-keyword',
				'label' => 'Cache Next And Previous Keyword'
			),
			'account_fields' => array(
				'id'=>'account-fields',
				'label'=>'Account Fields',
			),
			'account_details' => array(
				'id'=>'account-details',
				'label'=>'Account Details',
			),
			'single_properties' => array(
				'id'=>'property-single-details',
				'label'=>'Single Properties',
			),
			'coverage_lookup' => array(
				'id'=>'coverage-lookup',
				'label'=>'Coverage Lookup',
			),
		);
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

	public function getDefinedKeyword(){
		return json_decode(json_encode($this->arr_pre_define_cache_keyword), FALSE);
	}

	public function getDefinedCacheKeyword($keyword, $keyword_element = ''){
		$keyword_arr = array_keys($this->arr_pre_define_cache_keyword);
		$return_keyword = array();
		if( in_array($keyword, $keyword_arr) ){
			if( $keyword_element == '' ){
				$return_keyword = $this->arr_pre_define_cache_keyword[$keyword];
			}else{
				$return_keyword = $this->arr_pre_define_cache_keyword[$keyword][$keyword_element];
			}
			return json_decode(json_encode($return_keyword), FALSE);
		}
	}

	public function getLikeCacheOptionKey($option_name){
		global $wpdb;
		if( trim($option_name) != '' ){
			$sql = "SELECT * FROM $wpdb->options WHERE option_name like '%".$option_name."%'";
			return $wpdb->get_results($sql);
		}
	}

	/**
	 * This method will save the cache that was use
	 * - this will be handy so later the cache keyword will be getting handy
	 * - in this manner the keywords are in database and we dont need to scan every keyword that is used
	 * - we will be using update_site_option as our data to save, since we are using multisite
	 * -- the idea was to save the cache keyword on a particular site
	 * @param	$option_name	string		the name of the option
	 * 										or the key of pair
	 * @param	$option_value	string | array | object | mix		the value to be inserted
	 * 																or the value of pair
	 * @result update_site_option	@see http://codex.wordpress.org/Function_Reference/update_site_option
	 * */
	public function putCacheInfoDB($option_name, $option_value){
		if( get_option($option_name) ){
			return update_option($option_name, $option_value);
		}else{
			return add_option($option_name, $option_value);
		}
	}

	/**
	 * Put featured property keyword cache
	 * - this method uses function putCacheInfoDB
	 *
	 * */
	public function putFeaturedPropertyCache($option_value){
		$featured = $this->getCacheFeaturedKeyword();
		return $this->putCacheInfoDB($featured->id, $option_value);
	}

	/**
	 * Put featured property keyword cache
	 * - this method uses function putCacheInfoDB
	 *
	 * */
	public function putSearchedPropertyCache($option_value, $search_md5){
		$search = $this->getCacheSearchKeyword();
		return $this->putCacheInfoDB($option_value, $option_value);
	}

	public function getCacheSearchKeyword(){
		$search = $this->getDefinedCacheKeyword('search');
		return $search;
	}

	public function getCacheFeaturedKeyword(){
		return $this->getDefinedCacheKeyword('featured');
	}

	public function getCacheAutocompleteSearchKeyword(){
		return $this->getDefinedCacheKeyword('search_autocomplete');
	}

	public function getCacheAccountCoverageKeyword(){
		return $this->getDefinedCacheKeyword('account_coverage');
	}

	public function getCacheNavigationPropertyKeyword(){
		return $this->getDefinedCacheKeyword('navigation_property');
	}

	public function putNextPrevSearchPropertyCache($option_value, $search_md5){
		$search = $this->getCacheNavigationPropertyKeyword();
		return $this->putCacheInfoDB($search->id .'-'. $search_md5, $option_value);
	}

	//Next and Prev properties
	public function getCacheNextPrevKeyword(){
		return $this->getDefinedCacheKeyword('next_prev_keyword');
	}

	public function putCacheNextPrevKeywordCache($option_value){
		$search = $this->getCacheNextPrevKeyword();
		return $this->putCacheInfoDB($search->id, $option_value);
	}

	public function putSearchedPropertyNextPrevCache($option_value, $search_md5){
		$search = $this->getCacheNavigationPropertyKeyword();
		return $this->putCacheInfoDB($search->id .'-'. $search_md5, $option_value);
	}

	public function createNextPrevCache($search_data){
		$next_prev_search_keyword = $this->getCacheNextPrevKeyword();
		$keyword = $next_prev_search_keyword->id . get_current_blog_id();
		$this->putSearchedPropertyCache(md5(json_encode($search_data)),$keyword);
		\cache\FastCache::get_instance()->set($keyword, $search_data);
	}

	public function getNavigationListProperty($feed){
		if( $feed == 'mls' ){
			return \mls\Properties::get_instance()->getNextPrevData();
		}elseif( $feed == 'crm' ){
			return \crm\Properties::get_instance()->getNextPrevData();
		}
	}
	//Next and Prev properties

	// accounts
	public function getCacheAccountFieldsKeyword(){
		return $this->getDefinedCacheKeyword('account_fields');
	}

	public function putCacheAccountFieldsKeyword($option_value){
		$account_fields = $this->getCacheAccountFieldsKeyword();
		return $this->putCacheInfoDB($account_fields->id, $option_value);
	}

	public function createAccountFieldsCache($id, $data){
		$account_field_keyword 	= $this->getCacheAccountFieldsKeyword();
		$cache_keyword 			= $account_field_keyword->id .'-'. $id;
		$this->putCacheAccountFieldsKeyword($cache_keyword);
		\cache\FastCache::get_instance()->set($cache_keyword, $data);
	}

	public function getCacheAccountDetailsKeyword(){
		return $this->getDefinedCacheKeyword('account_details');
	}
	public function putCacheAccountDetailsKeyword($option_value){
		$account_fields = $this->getCacheAccountDetailsKeyword();
		return $this->putCacheInfoDB($account_fields->id, $option_value);
	}

	public function getCacheCoverageLookupKeyword(){
		return $this->getDefinedCacheKeyword('coverage_lookup');
	}

	// accounts

	//single
	public function getCacheSinglePropertyKeyword(){
		return $this->getDefinedCacheKeyword('single_properties');
	}

	public function putCacheSinglePropertyKeyword($option_value){
		$key = $this->getCacheSinglePropertyKeyword();
		return $this->putCacheInfoDB($key->id, $option_value);
	}

	public function createSinglePropertyCache($id, $data){
		$single_prop_keyword 	= $this->getCacheSinglePropertyKeyword();
		$cache_keyword 			= $single_prop_keyword->id .'-'. $id;
		$this->putCacheSinglePropertyKeyword($cache_keyword);
		\cache\FastCache::get_instance()->set($cache_keyword, $data);
	}
	//single

	public function resetAllCache($option_name){
		global $wpdb;

		if( trim($option_name) == '' ){
			$option_name = 'cache';
		}

		$get_data = $this->getLikeCacheOptionKey($option_name);
		if( count($get_data) > 0 ){
			$cache = new \cache\FastCache;
			foreach($get_data as $key => $val){
				// remove the cache file
				\cache\FastCache::delete($val->option_value);
				// remove the cache keyword in site option
				delete_option($val->option_name);
			}
		}
	}

	public function deleteCacheDB($option_name){
		global $wpdb;

		if( trim($option_name) == '' ){
			$option_name = 'cache';
		}

		$get_data = $this->getLikeCacheOptionKey($option_name);
		if( count($get_data) > 0 ){
			foreach($get_data as $key => $val){
				// remove the cache file
				//echo $val->option_value;
				//echo \cache\FastCache::get_instance()->isExists($val->option_value) ? 'y':'n';
				\cache\FastCache::delete($val->option_value);
				// remove the cache keyword in site option
			}
		}
	}
} // End Property_Cache
