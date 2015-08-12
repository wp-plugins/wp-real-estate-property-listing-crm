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

