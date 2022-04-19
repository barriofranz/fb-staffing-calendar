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
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
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
