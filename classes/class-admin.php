<?php

/**
 * The admin-specific functionality of the plugin.
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
class TCCI_Localize_Admin {

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
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->set_options();

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'admin_init', 									array( $this, 'register_fields' ) );
		add_action( 'admin_init', 									array( $this, 'register_sections' ) );
		add_action( 'admin_init', 									array( $this, 'register_settings' ) );
		add_action( 'admin_menu', 									array( $this, 'add_menu' ) );
		add_action( 'plugin_action_links_' . TCCI_LOCALIZE_FILE, 	array( $this, 'link_settings' ) );

	} // hooks()

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/classesistration_Menus
	 * @since 		1.0.0
	 */
	public function add_menu() {

		add_submenu_page(
			'options-general.php',
			esc_html__( 'T/CCI Localize Settings', 'tcci-localize' ),
			esc_html__( 'T/CCI Localize', 'tcci-localize' ),
			'manage_options',
			TCCI_LOCALIZE_SLUG . '-settings',
			array( $this, 'page_options' )
		);

	} // add_menu()

	/**
	 * Creates a text field
	 *
	 * Requires the ID parameter value.
	 *
	 * @param 	array 		$atts 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_text( $atts ) {

		$atts['name'] = TCCI_LOCALIZE_SLUG . '-options[' . $atts['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		?><input
			class="widefat"
			id="<?php echo esc_attr( $atts['id'] ); ?>"
			name="<?php echo esc_attr( $atts['name'] ); ?>"
			type="text"
			value="<?php echo esc_attr( $atts['value'] ); ?>" />
		<p class="description"><?php echo wp_kses( $atts['description'], array( 'code' => array() ) ); ?></p><?php

	} // field_text()

	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * Each item consists of the following:
	 * 		option name, field type, default value (used during plugin activation)
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();

		$options[] = array( 'project-key', 'text', '' );

		return $options;

	} // get_options_list()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$links 		The current array of links
	 *
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=posttypename&page=tcci-localize-settings' ), esc_html__( 'Settings', 'tcci-localize' ) );

		return $links;

	} // link_settings()

	/**
	 * Includes the options page view
	 *
	 * @since 		1.0.0
	 *
	 * @return 		void
	 */
	public function page_options() {

		?><h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php"><?php

		settings_fields( TCCI_LOCALIZE_SLUG . '-options' );

		do_settings_sections( TCCI_LOCALIZE_SLUG );

		submit_button( 'Save Settings' );

		?></form><?php

	} // page_options()

	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		add_settings_field(
			'project-key',
			apply_filters( TCCI_LOCALIZE_SLUG . '-label-project-key', esc_html__( 'Project Key', 'tcci-localize' ) ),
			array( $this, 'field_text' ),
			TCCI_LOCALIZE_SLUG,
			TCCI_LOCALIZE_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Enter the key for the Localize.js project.', 'tcci-localize' ),
				'id' 			=> 'project-key',
				'value' 		=> '',
			)
		);

	} // register_fields()

	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			TCCI_LOCALIZE_SLUG . '-settingssection',
			apply_filters( TCCI_LOCALIZE_SLUG . '-section-settingssection-title', esc_html__( '', 'tcci-localize' ) ),
			array( $this, 'section_settingssection' ),
			TCCI_LOCALIZE_SLUG
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			TCCI_LOCALIZE_SLUG . '-options',
			TCCI_LOCALIZE_SLUG . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_settingssection( $params ) {

		?><p> Login to your <a target="_blank" href="https://localizejs.com/">Localize.js</a> Dashboard to get your project key.</p><?php

	} // section_settingssection()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( TCCI_LOCALIZE_SLUG . '-options' );

	} // set_options()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$input 			array of submitted plugin options
	 *
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		$valid 		= array();
		$options 	= $this->get_options_list();

		foreach ( $options as $option ) {

			$sanitizer 			= new TCCI_Localize_Sanitize();
			$valid[$option[0]] 	= $sanitizer->clean( $input[$option[0]], $option[1] );

			unset( $sanitizer );

		}

		return $valid;

	} // validate_options()

} // class
