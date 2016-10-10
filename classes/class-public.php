<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link 		http://example.com
 * @since 		1.0.0
 * @package 	TCCI_Localize
 * @subpackage 	TCCI_Localize/classes
 * @author 		DCC Marketing <web@dccmarketing.com>
 */
class TCCI_Localize_Public {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options 		The plugin options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_options();

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_print_footer_scripts', array( $this, 'footer_scripts' ) );

	} // hooks()

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( empty( $this->options['project-key'] ) ) { return; }

		wp_enqueue_script( 'localize', '//cdn.localizejs.com/localize.js', false, null, false );

	} // enqueue_scripts()

	/**
	 * Initializes Localize.js in the footer.
	 */
	public function footer_scripts() {

		if ( empty( $this->options['project-key'] ) ) { return; }

		?><script>
			!function(a){if(!a.Localize){a.Localize={};for(var e=["translate","untranslate","phrase","initialize","translatePage","setLanguage","getLanguage","detectLanguage","getAvailableLanguages","untranslatePage","bootstrap","prefetch","on","off"],t=0;t<e.length;t++)a.Localize[e[t]]=function(){}}}(window);

			Localize.initialize({
				'key': <?php echo $this->options['project-key']; ?>,
				'rememberLanguage': true
			});
		</script><?php

	} // footer_scripts()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( TCCI_LOCALIZE_SLUG . '-options' );

	} // set_options()

} // class
