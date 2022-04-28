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


	protected $alertType = '';
	protected $alertMessage = '';
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

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( 'bootstrapcss','https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css', false, null );
			wp_enqueue_script( 'bootstappopperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js', false, null );
			wp_enqueue_script( 'bootstapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js', false, null );

			wp_enqueue_script('jquery-validate-min', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', false, null  );

			$css = plugins_url('fb-staffing-calendar/public/css/fb-staffing-calendar-public.css');
			wp_enqueue_style( 'fb_sc_css', $css);


			$js = plugins_url('fb-staffing-calendar/public/js/fb-staffing-calendar-public.js');
			wp_enqueue_script( 'fb_sc_js', $js);
			wp_localize_script( 'fb_sc_js', 'ajaxArr', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' )));

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
					'shift_schedules_location_verified'=>1,
		        ));

				$this->alertType = 'success';
				$this->alertMessage = 'Shift saved';
				add_action( 'admin_notices', [ $this, 'showNotice' ]);

				$dataid = $wpdb->insert_id;

				$shift = $this->getShiftSchedulesByID($dataid)[0];

				$fb_sc_emailfrom = get_option( 'fb_sc_emailfrom' );
				$fb_sc_calendarpw = get_option( 'fb_sc_calendarpw' );
// 				if ( $fb_sc_emailfrom !== false ) {
// $message = 'A new shift has been posted.<br>
// Here are the details:<br>
// <br>
// Location: '.$shift->location_name.'
// Shift type: '.$shift->shifttype_name.'
// From: '.$shift->shift_schedules_datefrom.' '.$shift->shift_schedules_timefrom.'
// To: '.$shift->shift_schedules_dateto.' '.$shift->shift_schedules_timeto.'
// 				';
//
// 					$to = [$fb_sc_emailfrom];
// 					$subject = "New shift schedule posted";
// 					$headers = 'From: '. $fb_sc_emailfrom . "\r\n" . 'Reply-To: ' . $fb_sc_emailfrom . "\r\n";
// 					$sent = wp_mail($to, $subject, strip_tags($message), $headers);
// 				}
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
					'shift_schedules_location_verified'=>1,
				],
				array('shift_schedules_id'=>$_POST['hidden_shift_id']));

				$this->alertType = 'success';
				$this->alertMessage = 'Shift updated';
				add_action( 'admin_notices', [ $this, 'showNotice' ]);

// 				$shift = $this->getShiftSchedulesByID($_POST['hidden_shift_id'])[0];
//
// 				$fb_sc_emailfrom = get_option( 'fb_sc_emailfrom' );
// if ( $fb_sc_emailfrom !== false ) {
// $message = 'A shift has been updated.<br>
// Here are the details:<br>
// <br>
// Location: '.$shift->location_name.'
// Shift type: '.$shift->shifttype_name.'
// From: '.$shift->shift_schedules_datefrom.' '.$shift->shift_schedules_timefrom.'
// To: '.$shift->shift_schedules_dateto.' '.$shift->shift_schedules_timeto.'
// 				';
//
// 				$to = [$fb_sc_emailfrom];
// 				$subject = "Shift schedule updated";
// 				$headers = 'From: '. $fb_sc_emailfrom . "\r\n" . 'Reply-To: ' . $fb_sc_emailfrom . "\r\n";
// 				$sent = wp_mail($to, $subject, strip_tags($message), $headers);
// }
			}

			if ( isset($_POST) && isset($_POST['submit_loc']) && $_POST['submit_loc']=='Add' ) {
				global $table_prefix, $wpdb;
				$wpdb->insert($wpdb->prefix . 'fb_sc_locations', array(
		            'location_name' => $_POST['loc_name'],
		        ));

				$this->alertType = 'success';
				$this->alertMessage = 'Location saved';
				add_action( 'admin_notices', [ $this, 'showNotice' ]);

			} else if ( isset($_POST) && isset($_POST['submit_loc']) && $_POST['submit_loc']=='Update' ) {
				global $table_prefix, $wpdb;
				$wpdb->update($wpdb->prefix . 'fb_sc_locations',
				[
					'location_name'=>$_POST['loc_name'],
				],
				array('location_id'=>$_POST['hidden_loc_id']));

				$this->alertType = 'success';
				$this->alertMessage = 'Location updated';
				add_action( 'admin_notices', [ $this, 'showNotice' ]);
			}

			if ( isset($_POST) && isset($_POST['submit_shifttype']) && $_POST['submit_shifttype']=='Add' ) {
				global $table_prefix, $wpdb;
				$wpdb->insert($wpdb->prefix . 'fb_sc_shift_type', array(
		            'shifttype_name' => $_POST['shifttype_name'],
		            'shifttype_colorcode' => $_POST['shifttype_colorcode'],
		        ));

				$this->alertType = 'success';
				$this->alertMessage = 'Shift type saved';
				add_action( 'admin_notices', [ $this, 'showNotice' ]);
			} else if ( isset($_POST) && isset($_POST['submit_shifttype']) && $_POST['submit_shifttype']=='Update' ) {
				global $table_prefix, $wpdb;
				$wpdb->update($wpdb->prefix . 'fb_sc_shift_type',
				[
					'shifttype_name'=>$_POST['shifttype_name'],
					'shifttype_colorcode'=>$_POST['shifttype_colorcode'],
				],
				array('shifttype_id'=>$_POST['hidden_shifttype_id']));

				$this->alertType = 'success';
				$this->alertMessage = 'Shift type updated';
				add_action( 'admin_notices', [ $this, 'showNotice' ]);
			}


			if ( isset($_POST) && isset($_POST['submit_fb_sc_settings']) && $_POST['submit_fb_sc_settings']=='Save' ) {
				$fb_sc_emailfrom = get_option( 'fb_sc_emailfrom' );
				$fb_sc_calendarpw = get_option( 'fb_sc_calendarpw' );

				$email =  $_POST['fb_sc_emailfrom'];
				$cal_pw =  trim($_POST['fb_sc_calendarpw']);
				$haserror = false;
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$this->alertType = 'warning';
					$this->alertMessage = 'Invalid Email';
					add_action( 'admin_notices', [ $this, 'showNotice' ]);
					$haserror = true;
				} else {

					if ( $fb_sc_emailfrom === false ) {
						add_option('fb_sc_emailfrom',$email);
					} else {
						update_option('fb_sc_emailfrom', $email);
					}
				}

				if ( $cal_pw !== '' ) {
					if ( $fb_sc_calendarpw === false ) {
						$options = [
							'cost' => 12,
						];
						$hash = password_hash($cal_pw, PASSWORD_BCRYPT, $options);
						substr( $hash, 0, 60 );
						add_option('fb_sc_calendarpw',$hash);
					} else {
						$options = [
							'cost' => 12,
						];
						$hash = password_hash($cal_pw, PASSWORD_BCRYPT, $options);
						substr( $hash, 0, 60 );
						update_option('fb_sc_calendarpw', $hash);
					}
				}

				echo "<pre>";print_r(strlen($hash));echo "</pre>";
				echo "<pre>";print_r($hash);echo "</pre>";

				if ( $haserror == false) {
					$this->alertType = 'success';
					$this->alertMessage = 'Saved';
					add_action( 'admin_notices', [ $this, 'showNotice' ]);
				}

			}

		}

	}

	public function showNotice() {

		echo '
		<br>
		<br>
		<div class="alert alert-'.$this->alertType.'" role="alert">
			'.$this->alertMessage.'
		</div>';
	}

	public function display_page()
	{
		$locations = $this->getLocations();
		$shift_types = $this->getShiftTypes();
		$shift_scheds = $this->getShiftSchedules();

		$fb_sc_emailfrom = get_option( 'fb_sc_emailfrom' );
		$fb_sc_calendarpw = get_option( 'fb_sc_calendarpw' );

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

	public function getShiftSchedulesByID( $dataid)
	{
		global $wpdb;
		$sql = '
		SELECT * FROM '.$wpdb->prefix.'fb_sc_shift_schedules t1
		left join ' . $wpdb->prefix . 'fb_sc_shift_type t2 on t1.shift_schedules_shifttype_id = t2.shifttype_id
		left join ' . $wpdb->prefix . 'fb_sc_locations t3 on t1.shift_schedules_location_id = t3.location_id
		WHERE shift_schedules_id = "'.$dataid.'"';
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
