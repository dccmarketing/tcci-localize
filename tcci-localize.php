<?php

/**
 * The plugin bootstrap file
 *
 * @link 		http://example.com
 * @since 		1.0.0
 * @author 		DCC Marketing <web@dccmarketing.com>
 * @package 	TCCI_Localize
 *
 * @wordpress-plugin
 * Plugin Name: 		T/CCI Localize
 * Plugin URI: 			http://example.com/tcci-localize/
 * Description: 		Integrates localize.js.
 * Version: 			1.0.0
 * DCC Marketing: 		DCC Marketing
 * DCC Marketing URI: 	http://example.com/
 * License: 			GPL-2.0+
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		tcci-localize
 * Domain Path: 		/assets/languages
 * Github Plugin URI: 	https://github.com/dccmarketing/tcci-localize
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Define constants
 */
define( 'TCCI_LOCALIZE_VERSION', '1.0.0' );
define( 'TCCI_LOCALIZE_SLUG', 'tcci-localize' );
define( 'TCCI_LOCALIZE_FILE', plugin_basename( __FILE__ ) );

/**
 * Activation/Deactivation Hooks
 */
register_activation_hook( __FILE__, 	array( 'TCCI_Localize_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, 	array( 'TCCI_Localize_Deactivator', 'deactivate' ) );

/**
 * Load Autoloader
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-autoloader.php';

/**
 * Initializes each class and adds the hooks action in each to after_setup_theme
 */
function tcci_localize_init() {

	/**
	 * Create an instance of each class and load the hooks function.
	 */
	$classes[] = 'Admin';
	$classes[] = 'i18n';
	$classes[] = 'Public';

	foreach ( $classes as $class ) {

		$class_name 	= 'TCCI_Localize_' . $class;
		$class_obj 		= new $class_name();

		add_action( 'after_setup_theme', array( $class_obj, 'hooks' ) );

	}

} // tcci_localize_init()

add_action( 'plugins_loaded', 'tcci_localize_init' );
