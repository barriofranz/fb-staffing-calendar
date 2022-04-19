<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/barriofranz
 * @since      1.0.0
 *
 * @package    Fb_Staffing_Calendar
 * @subpackage Fb_Staffing_Calendar/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Fb_Staffing_Calendar
 * @subpackage Fb_Staffing_Calendar/includes
 * @author     Franz Ian Barrio <barriofranz@gmail.com>
 */
class Fb_Staffing_Calendar_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::fb_sc_uninstall();
	}


	public function fb_sc_uninstall() {
		global $wpdb;
		global $jal_db_version;

		$sql = "DROP TABLE `" . $wpdb->prefix . "fb_sc_shift_type`;";
		$wpdb->query($sql);
		$sql = "DROP TABLE `" . $wpdb->prefix . "fb_sc_locations`;";
		$wpdb->query($sql);
		$sql = "DROP TABLE `" . $wpdb->prefix . "fb_sc_shift_schedules`;";
		$wpdb->query($sql);
	}

}
