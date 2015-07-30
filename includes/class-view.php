<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * View Class
 *
 * this render html template across plugin also can render template
 * there is a magic class a setter and getter we can use it also if we instantiate the class
 * sample:
 *
 * $view = new MasterdigmView();
 * $view->name = 'Foo';
 * echo $view->name;
 *
 * @since 3.12
 * @access (protected, public)
 * */
class MasterdigmView{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;

    /**
     * use for magic setters and getter
     * we can use this when we instantiate the class
     * it holds the variable from __set
     *
     * @see function __get, function __set
     * @access protected
     * @var array
     * */
    protected $vars = array();

    public function __construct() {}

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
	 * get current view folder
	 *
	 * @since 3.12
	 * @access public
	 *
	 * @return path / string
	 * */
	public function get_view_folder(){
		return PLUGIN_VIEW;
	}

	/**
	 * check and get template in theme
	 *
	 * this check if the current template file is in the current theme
	 * this is usefull in shortcodes where we assign page via doc comment
	 *
	 * @since 3.12
	 * @access public
	 * @param		string		$template_file
	 * @return string | bool, if the file exists return the directory path, else false
	 * */
	public function get_in_theme($template_file){
		$template = get_stylesheet_directory() .'/'. $template_file;
		if( file_exists($template) ){
			return $template;
		}
		return false;
	}

	/**
	 * check and get template/file in plugin
	 *
	 * this check if the current template file is in the plugin
	 * this is primarily use for getting template file inside plugin only
	 * for backend view purposes
	 *
	 * @since 3.12
	 * @access public
	 * @param		string		$template_file
	 * @return string | bool, if the file exists return the directory path, else false
	 * */
	public function get_in_plugin($template_file){
		$template = $this->get_view_folder() . $template_file;
		if( file_exists($template) ){
			//check in plugin
			return $template;
		}else{
			return false;
		}
	}

	/**
	 * get both template in theme or plugin
	 *
	 * we get both template file in theme first them plugin
	 *
	 * @since 3.12
	 * @access public
	 * @param	string	$template_file
	 * @return string | bool, if the file exists return the directory path, else false
	 * */
    public function get_view_part($template_file) {
		$template = '';

		//we check the template first
        if( $this->get_in_theme($template_file) ){
			//get template file in theme
			$template = $this->get_in_theme($template_file);
		}elseif( $this->get_in_plugin($template_file) ){
			//check in plugin
			$template = $this->get_in_plugin($template_file);
		}
		//if template exists return
		if( $template ){
			return $template;
		}
		return false;
    }

	/**
	 * require template file from theme
	 *
	 * this only render template file on the theme use only
	 *
	 * @since 3.12
	 * @access public
	 * @param	string	$template_file
	 * - the name of the file to be included
	 * @param	array	$data
	 * - set data to be pass in the template file, default is array
	 * @return require if exists else false
	 * */
	public function view_theme($template_file, $data = array()){
		extract($data);
		$template = $this->get_in_theme($template_file);
		if( $template ){
			//check in plugin
			require $template;
		}else{
			return false;
		}
	}

	/**
	 * require template file from plugin
	 *
	 * this only render template file on the plugin use only
	 *
	 * @since 3.12
	 * @access public
	 * @param	string	$template_file
	 * - the name of the file to be included
	 * @param	array	$data
	 * - set data to be pass in the template file, default is array
	 * @return require if exists else false
	 * */
	public function view_plugin($template_file, $data = array()){
		extract($data);
		$template = $this->get_in_plugin($template_file);
		if( $template ){
			//check in plugin
			require $template;
		}
		return false;
	}

	/**
	 * require both template in theme or plugin
	 *
	 * we require both template file in theme first them plugin
	 *
	 * @since 3.12
	 * @access public
	 * @param	string	$template_file
	 * @param	array	$data
	 * - we include data to be echo in the template file
	 * @return require | bool, if the file exists return the directory path, else false
	 * */
	public function view($template_file, $data = array()) {
		$template = '';

		/**
		 * extract the data so it will be variable only
		 * sample:
		 * $data['one'] = 1;
		 * would be $one and echo 1
		 * */
		extract($data);
		//we check the template first

        if( $this->get_in_theme($template_file) ){
			//get template file in theme
			$template = $this->get_in_theme($template_file);
		}elseif( $this->get_in_plugin($template_file) ){
			//check in plugin
			$template = $this->get_in_plugin($template_file);
		}
		//if template exists return
		if( $template ){
			require $template;
		}
		return false;
    }

	/**
	 * display the template file
	 * doesn't use the method get_view_folder()
	 * it check for file exists first then it display
	 *
	 * @since 3.12
	 * @access public
	 * @param	string	$template_file
	 * @param	array	$data
	 * @return require | bool, if the file exists return the directory path, else false
	 * */
	public function display($template_file, $data = array()){
		/**
		 * extract the data so it will be variable only
		 * sample:
		 * $data['one'] = 1;
		 * would be $one and echo 1
		 * */
		extract($data);
		if( file_exists($template_file) ){
			//check in plugin
			require $template_file;
		}else{
			return false;
		}
	}

	/**
	 * use object instantiate class
	 * */
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }

	/**
	 * use object instantiate class
	 * */
    public function __get($name) {
        return $this->vars[$name];
    }

}
