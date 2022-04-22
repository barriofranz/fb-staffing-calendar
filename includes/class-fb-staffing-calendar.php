<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/barriofranz
 * @since      1.0.0
 *
 * @package    Fb_Staffing_Calendar
 * @subpackage Fb_Staffing_Calendar/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Fb_Staffing_Calendar
 * @subpackage Fb_Staffing_Calendar/includes
 * @author     Franz Ian Barrio <barriofranz@gmail.com>
 */
class Fb_Staffing_Calendar {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Fb_Staffing_Calendar_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'FB_STAFFING_CALENDAR_VERSION' ) ) {
			$this->version = FB_STAFFING_CALENDAR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'fb-staffing-calendar';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
		add_action( 'init', array( $this, 'init' ), 20 );
	}

	public function enqueue_scripts() {
		global $current_screen;
		global $woocommerce;

		if ( 'toplevel_page_fb-staffing-calendar' === $current_screen->base ) {


			$css = plugins_url('fb-staffing-calendar/public/css/fb-staffing-calendar-public.css');
			wp_enqueue_style( 'fb_sc_css', $css);


			$js = plugins_url('fb-staffing-calendar/public/js/fb-staffing-calendar-public.js');
			wp_enqueue_script( 'fb_sc_js', $js);
			wp_localize_script( 'fb_sc_js', 'ajaxArr', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' )));

			wp_enqueue_style( 'bootstrapcss','https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css', false, null );
			wp_enqueue_script( 'bootstappopperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js', false, null );
			wp_enqueue_script( 'bootstapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js', false, null );

		}
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Fb_Staffing_Calendar_Loader. Orchestrates the hooks of the plugin.
	 * - Fb_Staffing_Calendar_i18n. Defines internationalization functionality.
	 * - Fb_Staffing_Calendar_Admin. Defines all hooks for the admin area.
	 * - Fb_Staffing_Calendar_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fb-staffing-calendar-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fb-staffing-calendar-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fb-staffing-calendar-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fb-staffing-calendar-public.php';

		$this->loader = new Fb_Staffing_Calendar_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Fb_Staffing_Calendar_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Fb_Staffing_Calendar_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Fb_Staffing_Calendar_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Fb_Staffing_Calendar_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Fb_Staffing_Calendar_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	public function add_menu_item() {
		if ( is_admin() ) {
			add_menu_page(
				'Staffing Calendar Shifts',
				'Staffing Calendar Shifts',
				'edit_users',
				'fb-staffing-calendar',
				array( $this, 'display_page' ),
				'dashicons-calendar-alt'
			);
		}
		return false;
	}

	public function init()
	{
		if ( isset( $_GET['page'] ) && 'fb-staffing-calendar' === $_GET['page'] ) {
			// echo "<pre>";print_r($_POST);echo "</pre>";die();
			if ( isset($_POST) && isset($_POST['submit_shift']) && $_POST['submit_shift']=='Add' ) {

				global $table_prefix, $wpdb;
				$wpdb->insert($wpdb->prefix . 'fb_sc_shift_schedules', array(
		            'shift_schedules_location_id' => $_POST['location_id'],
		            'shift_schedules_shifttype_id' => $_POST['shift_id'],
		            'shift_schedules_datefrom' => $_POST['date_from'],
		            'shift_schedules_timefrom' => $_POST['time_from'],
		            'shift_schedules_dateto' => $_POST['date_to'],
		            'shift_schedules_timeto' => $_POST['time_to'],
		        ));

			} else if ( isset($_POST) && isset($_POST['submit_shift']) && $_POST['submit_shift']=='Update' ) {
				global $table_prefix, $wpdb;
				$wpdb->update($wpdb->prefix . 'fb_sc_shift_schedules',
				[
					'shift_schedules_location_id'=>$_POST['location_id'],
					'shift_schedules_shifttype_id'=>$_POST['shift_id'],
					'shift_schedules_datefrom'=>$_POST['date_from'],
					'shift_schedules_timefrom'=>$_POST['time_from'],
					'shift_schedules_dateto'=>$_POST['date_to'],
					'shift_schedules_timeto'=>$_POST['time_to'],
				],
				array('shift_schedules_id'=>$_POST['hidden_shift_id']));

			}

			if ( isset($_POST) && isset($_POST['submit_loc']) && $_POST['submit_loc']=='Add' ) {
				global $table_prefix, $wpdb;
				$wpdb->insert($wpdb->prefix . 'fb_sc_locations', array(
		            'location_name' => $_POST['loc_name'],
		        ));
			} else if ( isset($_POST) && isset($_POST['submit_loc']) && $_POST['submit_loc']=='Update' ) {
				global $table_prefix, $wpdb;
				$wpdb->update($wpdb->prefix . 'fb_sc_locations',
				[
					'location_name'=>$_POST['loc_name'],
				],
				array('location_id'=>$_POST['hidden_loc_id']));
			}

			if ( isset($_POST) && isset($_POST['submit_shifttype']) && $_POST['submit_shifttype']=='Add' ) {
				global $table_prefix, $wpdb;
				$wpdb->insert($wpdb->prefix . 'fb_sc_shift_type', array(
		            'shifttype_name' => $_POST['shifttype_name'],
		        ));
			} else if ( isset($_POST) && isset($_POST['submit_shifttype']) && $_POST['submit_shifttype']=='Update' ) {
				global $table_prefix, $wpdb;
				$wpdb->update($wpdb->prefix . 'fb_sc_shift_type',
				[
					'shifttype_name'=>$_POST['shifttype_name'],
				],
				array('shifttype_id'=>$_POST['hidden_shifttype_id']));
			}

		}
	}

	public function display_page()
	{
		$locations = $this->getLocations();
		$shift_types = $this->getShiftTypes();
		$shift_scheds = $this->getShiftSchedules();
		// echo "<pre>";print_r($shift_scheds);echo "</pre>";die();
		include_once __DIR__ . '/../public/partials/shift_form.php';
	}

	public function getShiftSchedules()
	{
		global $wpdb;
		$sql = "
			SELECT *
			from " . $wpdb->prefix . "fb_sc_shift_schedules t1
			left join " . $wpdb->prefix . "fb_sc_shift_type t2 on t1.shift_schedules_shifttype_id = t2.shifttype_id
			left join " . $wpdb->prefix . "fb_sc_locations t3 on t1.shift_schedules_location_id = t3.location_id
			;
		";
		// echo "<pre>";print_r($sql);echo "</pre>";die();
		return $wpdb->get_results( $sql );
	}

	public function getLocations()
	{
		global $wpdb;

		return $wpdb->get_results( "
			SELECT * from " . $wpdb->prefix . "fb_sc_locations;
		");

	}

	public function getShiftTypes()
	{
		global $wpdb;

		return $wpdb->get_results( "
			SELECT * from " . $wpdb->prefix . "fb_sc_shift_type;
		");

	}
}
