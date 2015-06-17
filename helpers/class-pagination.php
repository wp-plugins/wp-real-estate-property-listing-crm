<?php
/**
 * Helper class for pagination
 * */
class Pagination {
	protected static $instance = null;

	public function __construct(){
		//set default values
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
	 * Build the links url
	 * @param	int	$page_number	pass the page number from the url
	 *
	 * @return string
	 * */
	private function build_links_query($page_number){
		global $wp_query;
		if( get_option('permalink_structure') ){
			//pretty link
			$current_page = $wp_query->query_vars['pagename'];
			switch($current_page){
				case 'search-properties':
					/*if( isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ) {
						$server_query_string = $_SERVER['QUERY_STRING'] ? '/?' . $_SERVER['QUERY_STRING']:$_SERVER['QUERY_STRING'];
					}else{
						$server_query_string = \Property_URL::get_instance()->get_search_page_default();
					}*/
					//$query_string = $page_number . $server_query_string;
					$query_string = \Property_URL::get_instance()->get_search_page_default() .'page/'.$page_number;
				break;
				case 'city':
					$query_string = '/?pg='.$page_number;
				break;
			}

		}else{
			parse_str($_SERVER['QUERY_STRING'], $query_string);
			$query_string['page'] = $page_number;
			unset($query_string['page_id']);
			$query_string = '&' . http_build_query($query_string);
		}
		return $query_string;
	}

	public function getHost(){
		global $wp_query;
		$current_page = $wp_query->query_vars['pagename'];
		switch($current_page){
			case 'search-properties':
				$search = 'search-properties';
				$host 	= \Property_URL::get_instance()->get_permalink_property($search);
				return $host;
			break;
			case 'city':
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->city_pagename);
				return $url . $wp_query->query['cityid'] . '/' . $wp_query->query['cityname'];
			break;
		}
	}

	/**
	 * This is for the infinite scroll
	 * */
	public function next_prev($label = 'standard', $wide = true, $limit = null, $max_num_pages = null){
		$data_array 	= array();
		$current_total	= 0;
		$next_url		= '';
		$prev_url		= '';
		$li_previous	= '';
		$li_next	= '';

		if( $wide ){
			$li_previous = 'previous';
			$li_next = 'next';
		}

		if( $label == 'standard' ){
			$next 			= 'Next';
			$previous 		= 'Previous';
		}
		$single_property 	= \MD_Single_Property::get_instance()->getPropertyData();
		if( $single_property['source'] == DEFAULT_FEED ){
			$nav 				= \Property_Cache::get_instance()->getNavigationListProperty($single_property['source']);
			if( $nav ){
				$current_property_id 	= $single_property['property_id'];

				if( is_null($limit) ){
					$limit = 10;
				}

				if( is_null($max_num_pages) ){
					$max_num_pages 	= count($nav->data);
				}

				$paged = $nav->search_keyword['page'] ? absint( $nav->search_keyword['page'] ) : 1;
				$max   = ceil( intval( $max_num_pages ) / $limit );

				$current_total = count($nav->data);
				if( count($nav->data) > 0 ){
					foreach($nav->data as $key => $val){
						if( $single_property['source'] == 'crm' ){
							$real_property_id = $val->id;
						}elseif( $single_property['source'] == 'mls' ){
							$real_property_id = $val->Matrix_Unique_ID;
						}

						$data_array[$real_property_id] = array(
							'url' 	=> $val->displayURL(),
							'name' 	=> $val->displayAddress()
						);
					}
				}

				$array_key				= array_search($current_property_id,array_keys($data_array));
				$current_record_key 	= ($array_key + 1);

				if( $array_key == 0 ){
					$previous_record_key 	= 0;
				}else{
					$previous_record_key 	= ($array_key - 1);
					$property_id  = (array_keys($data_array)[$previous_record_key]);
					$prev_url	= $data_array[$property_id]['url'];
					if( $label == 'name' ){
						$previous	= $data_array[$property_id]['name'];
					}
				}

				if( $current_total != $current_record_key ){
					$next_record_key 	= ($array_key + 1);
					$property_id  = (array_keys($data_array)[$next_record_key]);
					$next_url	= $data_array[$property_id]['url'];
					if( $label == 'name' ){
						$next	= $data_array[$property_id]['name'];
					}
				}
				echo '<nav>';
				  echo '<ul class="pager">';

					if( trim($prev_url) != '' ){
						echo '<li class="prev-link-li '.$li_previous.'">';
							echo '<a href="'.$prev_url.'" class="prev-link-href">';
								echo $previous;
							echo '</a>';
						echo '</li>';
					}

					if( $current_total != $current_record_key   ){
						echo '<li class="prev-link-li '.$li_next.'">';
							echo '<a href="'.$next_url.'" class="next-link-href">';
								echo $next;
							echo '</a>';
						echo '</li>';
					}

				  echo '</ul>';
				echo '</nav>';
			}
		}//$single_property['source'] == DEFAULT_FEED
	}

	/**
	 * create the pagination
	 * @param	array | optional	$data	holds the data, also if $max_num_pages is null
	 * 										we count the data or the size of it as alternative
	 * @param	int	$max_num_pages	the total number of data
	 *
	 * @return mix | html
	 * */
	public function wp_nav( $data = array(), $max_num_pages = null ){
		$host 	= $this->getHost();

		$limit = get_query_var( 'limit' ) ? absint( get_query_var( 'limit' ) ) : 11;

		if( !$max_num_pages ){
			$max_num_pages = count($data);
		}

		/** Stop execution if there's only 1 page */
		if( $max_num_pages <= 1 )
			return;

		if( isset($_REQUEST['pg']) ){
			$paged = $_REQUEST['pg'];
		}else{
			$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		}

		$max   = ceil( intval( $max_num_pages ) / $limit );

		/**	Add current page to the array */
		if ( $paged >= 1 ){
			$links[] = $paged;
		}
		/**	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="property-navigation"><ul class="pagination">' . "\n";
		/**	Previous Post Link */
		if ( $paged > 1 )
			printf( '<li><a href="%s">%s</a></li>' . "\n", get_pagenum_link($paged - 1), '&laquo;' );

		/**	Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link(1), '1' );

			if ( ! in_array( 2, $links ) )
				echo '<li class="dishttp://local.dev/masterdigmwp/horizonpalm/00aa/abled"><span>…</span></li>' . "\n";
		}
		/**	Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link($link), $link );
		}
		/**	Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) )
				echo '<li class="disabled"><span>…</span></li>' . "\n";

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link($max), $max );
		}

		/**	Next Post Link */
		if ( $paged < $max )
			printf( '<li><a href="%s">%s</a></li>' . "\n", get_pagenum_link($paged+1), '&raquo;' );
		echo '</ul></div>';
	}

	public function md_pagination_pagenum($page_num, $url){
		//if( is_null($url) ){
			return get_pagenum_link($page_num);
		/*}else{
			$current_query_url = '';
			if( isset($url['current_query_url']) ){
				$current_query_url = $url['current_query_url'];
			}
			$current_site_url = '';
			if( isset($url['current_site_url']) ){
				$current_site_url = $url['current_site_url'];
			}
			$current_page = '';
			if( isset($url['current_page']) ){
				$current_page = $url['current_page'];
			}
			return $current_site_url.'/'.$current_page.'/page/'.$page_num.'/?'.$current_query_url;
		}*/
	}

	public function md_pagination($pages = '', $range = 2, $max_num_pages = null, $url = array())
	{
		$showitems = ($range * 2)+1;
		global $paged;
		if(empty($paged)){
		  $paged = 1;
		}

		$limit = get_query_var( 'limit' ) ? absint( get_query_var( 'limit' ) ) : \MD_Search_Utility::get_instance()->search_limit();
		$max   = ceil( intval( $max_num_pages ) / $limit );

		if($pages == ''){
		 global $wp_query;
		 $pages = $max;
		 if(!$pages)
		 {
			 $pages = 1;
		 }
		}

		 if(1 != $pages)
		 {
			 echo "<div class='pagination'>";
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".$this->md_pagination_pagenum(1, $url)."'>&laquo;</a>";
			 if($paged > 1 && $showitems < $pages) echo "<a href='".$this->md_pagination_pagenum($paged - 1,$url)."'>&lsaquo;</a>";

			 for ($i=1; $i <= $pages; $i++)
			 {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				 {
					 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".$this->md_pagination_pagenum($i,$url)."' class='inactive' >".$i."</a>";
				 }
			 }

			 if ($paged < $pages && $showitems < $pages) echo "<a href='".$this->md_pagination_pagenum($paged + 1,$url)."'>&rsaquo;</a>";
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".$this->md_pagination_pagenum($pages,$url)."'>&raquo;</a>";
			 echo "</div>\n";
		 }
	}

}

