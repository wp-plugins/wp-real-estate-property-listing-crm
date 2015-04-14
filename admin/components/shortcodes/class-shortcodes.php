<?php
/**
 * main short code for api
 * */
class Shortcode_Tinymce{

	protected static $instance = null;

	public $parent_menu_label = 'Masterdigm API';

	public $parent_menu 		= array();
	public $child_parent_menu 	= array();

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

	public function __construct(){
        add_action('admin_init', array($this, 'md_shortcode_button'));
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
    }

	/**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function md_shortcode_button()
    {
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
        {
            add_filter( 'mce_external_plugins', array($this, 'md_add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'md_register_buttons' ));
        }
    }

	/**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function md_add_buttons( $plugin_array )
    {
        $plugin_array['mdshortcodes'] = plugin_dir_url( __FILE__ ) . 'js/shortcode-tinymce-button.js';

        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function md_register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'mdshortcodes' );
        return $buttons;
    }

    public function get_parent_menu_label(){
		return $this->parent_menu_label;
	}

	public function set_parent_menu($id,$menu_label){
		$this->parent_menu[] = array(
			'id' 	=> $id,
			'label'	=> $menu_label
		);
	}

	public function get_parent_menu(){
		return $this->parent_menu;
	}

	/**
	 * @param	$option		array		 default option attributes
	 * - is_
	 * */
	public function set_child_menu($parent_id, $menu_text, $content, $option = array()){

	}

    /**
     * Add shortcode JS to the page
     *
     * @return HTML
     */
    public function md_get_shortcodes()
    {
		$menu_parent = $this->get_parent_menu();
        ?>
			<script type="text/javascript">
				var menu_button_label 	= '<?php echo $this->get_parent_menu_label(); ?>';
				var has_mls_key 		= '<?php echo has_mls_key() ? 1:0;?>';
				var has_crm_key 		= '<?php echo has_crm_key() ? 1:0;?>';
			</script>
        <?php
    }

}
