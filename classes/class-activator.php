<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link 		http://example.com
 * @since 		1.0.0
 * @author 		DCC Marketing <web@dccmarketing.com>
 * @package 	TCCI_Localize
 * @subpackage 	TCCI_Localize/classes
 */
class TCCI_Localize_Activator {

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-admin.php';

		$opts 		= array();
		$options 	= TCCI_Localize_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'tcci-localize-options', $opts );

	} // activate()

} // class
