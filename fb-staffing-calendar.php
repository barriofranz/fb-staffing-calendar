<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/barriofranz
 * @since             1.0.0
 * @package           Fb_Staffing_Calendar
 *
 * @wordpress-plugin
 * Plugin Name:       FB Staffing Calendar
 * Plugin URI:        https://github.com/barriofranz
 * Description:       Plugin for custom calendar
 * Version:           1.0.5
 * Author:            Franz Ian Barrio
 * Author URI:        https://github.com/barriofranz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fb-staffing-calendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FB_STAFFING_CALENDAR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fb-staffing-calendar-activator.php
 */
function activate_fb_staffing_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fb-staffing-calendar-activator.php';
	Fb_Staffing_Calendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fb-staffing-calendar-deactivator.php
 */
function deactivate_fb_staffing_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fb-staffing-calendar-deactivator.php';
	Fb_Staffing_Calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fb_staffing_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_fb_staffing_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fb-staffing-calendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fb_staffing_calendar() {

	$plugin = new Fb_Staffing_Calendar();
	$plugin->run();

}
run_fb_staffing_calendar();


add_action("wp_ajax_getShiftScheduleData", "getShiftScheduleData");
function getShiftScheduleData()
{
	global $wpdb;

	$dataid = $_POST['dataid'];

	$sql = '
	SELECT * FROM '.$wpdb->prefix.'fb_sc_shift_schedules WHERE shift_schedules_id = "'.$dataid.'"';

	$result = $wpdb->get_results($sql);
	echo json_encode($result[0]);

	die();
}

add_action("wp_ajax_getLocData", "getLocData");
function getLocData()
{
	global $wpdb;

	$dataid = $_POST['dataid'];

	$sql = '
	SELECT * FROM '.$wpdb->prefix.'fb_sc_locations WHERE location_id = "'.$dataid.'"';

	$result = $wpdb->get_results($sql);
	echo json_encode($result[0]);

	die();
}

add_action("wp_ajax_getShiftTypeData", "getShiftTypeData");
function getShiftTypeData()
{
	global $wpdb;

	$dataid = $_POST['dataid'];

	$sql = '
	SELECT * FROM '.$wpdb->prefix.'fb_sc_shift_type WHERE shifttype_id = "'.$dataid.'"';

	$result = $wpdb->get_results($sql);
	echo json_encode($result[0]);

	die();
}

add_action("wp_ajax_toggleVerifyShift", "toggleVerifyShift");
function toggleVerifyShift()
{
	global $wpdb;

	$dataid = $_POST['dataid'];
	$state = $_POST['state'] == 1 ? 'null' : '1';

	$bindArr = [$state, $dataid];
	$sql = '
	UPDATE '.$wpdb->prefix.'fb_sc_shift_schedules SET shift_schedules_location_verified = %s WHERE shift_schedules_id = %d';
	$sql = $wpdb->prepare($sql, $bindArr);
	$wpdb->get_results($sql);

	$wpdb->get_results($sql);
	// echo json_encode($result[0]);
}

add_action("wp_ajax_deleteShiftScheduleData", "deleteShiftScheduleData");
function deleteShiftScheduleData()
{
	global $wpdb;

	$dataid = $_POST['dataid'];
	$sql = '
	DELETE FROM '.$wpdb->prefix.'fb_sc_shift_schedules WHERE shift_schedules_id = "'.$dataid.'"';

	$wpdb->get_results($sql);
	// echo json_encode($result[0]);
}

add_action("wp_ajax_deleteLocData", "deleteLocData");
function deleteLocData()
{
	global $wpdb;

	$dataid = $_POST['dataid'];
	$sql = '
	DELETE FROM '.$wpdb->prefix.'fb_sc_locations WHERE location_id = "'.$dataid.'"';

	$wpdb->get_results($sql);
	// echo json_encode($result[0]);
}

add_action("wp_ajax_deleteShiftTypeData", "deleteShiftTypeData");
function deleteShiftTypeData()
{
	global $wpdb;

	$dataid = $_POST['dataid'];
	$sql = '
	DELETE FROM '.$wpdb->prefix.'fb_sc_shift_type WHERE shifttype_id = "'.$dataid.'"';

	$wpdb->get_results($sql);
	// echo json_encode($result[0]);
}

add_action("wp_ajax_getCalendarDays", "getCalendarDays");
add_action("wp_ajax_nopriv_getCalendarDays", "getCalendarDays");
function getCalendarDays()
{

	$month = $_POST['month'];
	$year = $_POST['year'];
	$shifttype = $_POST['shifttype'];
	$location = $_POST['location'];

	$yearmonth = $year . '/' . $month . '/01';

	$timestamp = strtotime('next Sunday');
	$days = array(); //used
	for ($i = 0; $i < 7; $i++) {
	    $days[] = strftime('%A', $timestamp);
	    $timestamp = strtotime('+1 day', $timestamp);
	}

	$maxDays=date('t',strtotime($yearmonth)); //used
	$currentDayOfMonth=date('j'); //used
	$currentDayLastOfMonth=date('w', strtotime($year . '/' . $month . '/' . $maxDays)); //used

	$firstDayOffset = date('w',strtotime($yearmonth)); //used
	// echo "<pre>";print_r($currentDayLastOfMonth);echo "</pre>";die();

	$daysWithShifts = getDaysWithShifts($year, $month, $shifttype, $location);
	include_once __DIR__ . '/public/partials/calendardays.php';



	die();
}


function getDaysWithShifts($year, $month, $shifttype, $location)
{
	global $wpdb;


	$bindArr = [$month, $year,];
	$sql = '
	SELECT * FROM '.$wpdb->prefix.'fb_sc_shift_schedules t1
	LEFT JOIN '.$wpdb->prefix.'fb_sc_shift_type t2 on t1.shift_schedules_shifttype_id = t2.shifttype_id
	WHERE
	shift_schedules_location_verified = 1
	AND MONTH(t1.shift_schedules_datefrom) = "%d"
	AND YEAR(t1.shift_schedules_datefrom) = "%d"
	AND (t1.shift_schedules_email IS NULL OR t1.shift_schedules_email = "")
	';


	$shifttypeCond = '';
	if ( $shifttype != 0 ) {
		$sql .= '
		AND t1.shift_schedules_shifttype_id = "%d"';
		// AND shift_schedules_shifttype_id = "' . $shifttype. '"';
		$bindArr[] = $shifttype;
	}
	$locCond = '';
	if ( $location != 0 ) {
		$sql .= '
		AND t1.shift_schedules_location_id = "%d"';
		// AND shift_schedules_location_id = "' . $location. '"';
		$bindArr[] = $location;
	}

	$sql = $wpdb->prepare($sql, $bindArr);

	$shifts = $wpdb->get_results($sql);

	$shifts1 = [];
	$shifts2 = [];
	foreach ($shifts as $shift) {
		$day = date('d', strtotime($shift->shift_schedules_datefrom));
		if (empty($shift->shift_schedules_email)) {
			if (!array_key_exists($day, $shifts1)) {
				$shifts1[$day] = [];
			}
			if (!array_key_exists($shift->shifttype_name, $shifts1[$day])) {
				$shifts1[$day][$shift->shifttype_name]['count'] = 0;
				$shifts1[$day][$shift->shifttype_name]['colorcode'] = $shift->shifttype_colorcode;
			}

			$shifts1[$day][$shift->shifttype_name]['count']++;

		} else {
			if (!array_key_exists($day, $shifts2)) {
				$shifts2[$day] = 0;
			}
			$shifts2[$day]++;
		}

	}
	// echo "<pre>";print_r($shifts1);echo "</pre>";die();
	return [
		'unclaimed' => $shifts1,
		'claimed' => $shifts2,
	];
}


add_action("wp_ajax_getDateShifts", "getDateShifts");
add_action("wp_ajax_nopriv_getDateShifts", "getDateShifts");
function getDateShifts()
{
	global $wpdb;

	$date = $_POST['date'];

	$sql = '
	SELECT * FROM '.$wpdb->prefix.'fb_sc_shift_schedules t1
	left join ' . $wpdb->prefix . 'fb_sc_shift_type t2 on t1.shift_schedules_shifttype_id = t2.shifttype_id
	left join ' . $wpdb->prefix . 'fb_sc_locations t3 on t1.shift_schedules_location_id = t3.location_id
	WHERE shift_schedules_datefrom = "'.$date.'"';

	$shift_schedules = $wpdb->get_results($sql);

	include_once __DIR__ . '/public/partials/availableshifts-rows.php';

	die();
}

add_action("wp_ajax_updateShiftEmail", "updateShiftEmail");
add_action("wp_ajax_nopriv_updateShiftEmail", "updateShiftEmail");
function updateShiftEmail()
{
	global $wpdb;
	$email = $_POST['email'];
	$dataid = $_POST['dataid'];

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo json_encode(['success'=>2]);
  	  	die();
	}
	include_once __DIR__ . '/includes/class-fb-staffing-calendar.php';
	$scInc = new Fb_Staffing_Calendar;
	$res = $scInc->getShiftSchedulesByID($dataid)[0];

	if ( empty($res->shift_schedules_email) ) {
		$shift = $res;
		$bindArr = [$email,$dataid];
		$sql = '
		UPDATE '.$wpdb->prefix.'fb_sc_shift_schedules SET shift_schedules_email = "%s" WHERE shift_schedules_id = "%d"';
		$sql = $wpdb->prepare($sql, $bindArr);
		$wpdb->get_results($sql);

		echo json_encode(['success'=>1]);

		$fb_sc_emailfrom = get_option( 'fb_sc_emailfrom' );
		if ( $fb_sc_emailfrom !== false ) {

$message = 'A shift has been claimed.<br>
Here are the details:<br>
<br>
Location: '.$shift->location_name.'
Shift type: '.$shift->shifttype_name.'
From: '.$shift->shift_schedules_datefrom.' '.$shift->shift_schedules_timefrom.'
To: '.$shift->shift_schedules_dateto.' '.$shift->shift_schedules_timeto.'
Claimed by: '.$email.'
		';

			$to = [$email, $fb_sc_emailfrom];
			$subject = "Shift schedule claimed";
			$headers = 'From: '. $fb_sc_emailfrom . "\r\n" . 'Reply-To: ' . $fb_sc_emailfrom . "\r\n";
			$sent = wp_mail($to, $subject, strip_tags($message), $headers);
		}
		die();
	}

	echo json_encode(['success'=>0]);

	die();
}


// add_action("wp_ajax_submitShiftRequest", "submitShiftRequest");
// add_action("wp_ajax_nopriv_submitShiftRequest", "submitShiftRequest");
function submitShiftRequest()
{

	global $table_prefix, $wpdb;
	$wpdb->insert($wpdb->prefix . 'fb_sc_shift_schedules', array(
		'shift_schedules_location_id' => $_POST['location_id'],
		'shift_schedules_shifttype_id' => $_POST['shift_id'],
		'shift_schedules_datefrom' => $_POST['date_from'],
		'shift_schedules_timefrom' => $_POST['time_from'],
		'shift_schedules_dateto' => $_POST['date_to'],
		'shift_schedules_timeto' => $_POST['time_to'],
		'shift_schedules_location_verified'=>0,
		'shift_schedules_email'=>$_POST['email'],
	));

	$dataid = $wpdb->insert_id;
	$scInc = new Fb_Staffing_Calendar;
	$shift = $scInc->getShiftSchedulesByID($dataid)[0];

	$fb_sc_emailfrom = get_option( 'fb_sc_emailfrom' );
	if ( $fb_sc_emailfrom !== false ) {

$message = 'A shift has been requested.<br>
Here are the details:<br>
<br>
Location: '.$shift->location_name.'
Shift type: '.$shift->shifttype_name.'
From: '.$shift->shift_schedules_datefrom.' '.$shift->shift_schedules_timefrom.'
To: '.$shift->shift_schedules_dateto.' '.$shift->shift_schedules_timeto.'
Claimed by: '.$_POST['email'].'
';

		$to = [$fb_sc_emailfrom];
		$subject = "Shift schedule requested";
		$headers = 'From: '. $fb_sc_emailfrom . "\r\n" . 'Reply-To: ' . $fb_sc_emailfrom . "\r\n";
		$sent = wp_mail($to, $subject, strip_tags($message), $headers);
	}

}

add_shortcode( 'fb_sc_display_calendar', 'fb_sc_display_calendar_func' );
function fb_sc_display_calendar_func( $atts )
{
	include_once __DIR__ . '/includes/class-fb-staffing-calendar.php';
	if( isset( $_POST['submit_shift_request'] ) )
    {
        submitShiftRequest();
		$doRefresh = 1;
    }
	wp_enqueue_script("jquery");
	// $css = plugins_url('fb-staffing-calendar/public/css/fb-staffing-calendar-public.css');
	// wp_enqueue_style( 'fb_sc_css', $css);

	$js = plugins_url('fb-staffing-calendar/public/js/fb-sc-frontjs.js');
	wp_enqueue_script('fb_sc_front_js', $js, array('jquery'));
	wp_localize_script( 'fb_sc_front_js', 'ajaxArr', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' )));

	// wp_enqueue_script( 'bootstppopperjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', false, null );
	// wp_enqueue_script( 'bootstppopperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js', false, null );

	wp_enqueue_style( 'bootstrapcss','https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css', false, null );
	wp_enqueue_script( 'bootstapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js', false, null );



	$scInc = new Fb_Staffing_Calendar;
	$shiftTypes = $scInc->getShiftTypes();
	$locations = $scInc->getLocations();
	// echo "<pre>";print_r($getShiftTypes);echo "</pre>";die();
	include_once __DIR__ . '/public/partials/calendar_template.php';
	return;
}
