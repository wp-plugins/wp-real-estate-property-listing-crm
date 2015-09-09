<?php
/**
 * we will use this to be a helper for the admin functionality
 *
 * */
class Masterdigm_Admin_Util {

	protected static $instance = null;

	public $array_error = array();

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

	public function redirect_to($url){
		?>
		<script type="text/javascript">
			window.location = '<?php echo $url; ?>';
		</script>
		<?php
		die();
	}

	public function popup_window($url, $target = '_self'){
		?>
		<script type="text/javascript">
			window.open('<?php echo $url; ?>','<?php echo $target;?>');
		</script>
		<?php
		die();
	}

	public function setError($array_error){
		$this->array_error = $array_error;
	}

	public function getError(){
		return $this->array_error;
	}

}
