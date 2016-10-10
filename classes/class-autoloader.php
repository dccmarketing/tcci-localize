<?php

/**
 * Autoloader for PHP 5.3+
 *
 * @link 		http://example.com
 * @since 		1.0.0
 * @author 		DCC Marketing <web@dccmarketing.com>
 * @package 	TCCI_Localize
 * @subpackage 	TCCI_Localize/classes
 */
class TCCI_Localize_Autoloader {

	/**
	 * Autoloader function
	 *
	 * Will search both plugin root and includes folder for class
	 *
	 * @param string $class_name
	 */
	public static function autoloader( $class_name ) {

		$class_name = str_replace( 'TCCI_Localize_', '', $class_name );
		$lower 		= strtolower( $class_name );
		$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
		$base_path 	= plugin_dir_path( __FILE__ );
		$paths[] 	= $base_path . $file;
		$paths[] 	= $base_path . 'classes/' . $file;

		/**
		 * TCCI_LOCALIZE_autoloader_paths filter
		 */
		$paths = apply_filters( 'tcci-localize-autoloader-paths', $paths );

		foreach ( $paths as $path ) :

			if ( is_readable( $path ) && file_exists( $path ) ) {

				require_once( $path );
				return;

			}

		endforeach;

	} // autoloader()

} // class

spl_autoload_register( 'TCCI_Localize_Autoloader::autoloader' );
