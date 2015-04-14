<?php
require_once plugin_dir_path( __FILE__ ) . 'class-pdf.php';
add_action( 'plugins_loaded', array( 'PDF_MD', 'get_instance' ) );
