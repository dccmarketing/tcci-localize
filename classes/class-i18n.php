<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link 		http://example.com
 * @since 		1.0.0
 * @author 		DCC Marketing <web@dccmarketing.com>
 * @package 	TCCI_Localize
 * @subpackage 	TCCI_Localize/classes
 */
class TCCI_Localize_i18n {

	function __construct(){}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

	} // hooks()

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tcci-localize',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/assets/languages/'
		);

	} // load_plugin_textdomain()

} // class
