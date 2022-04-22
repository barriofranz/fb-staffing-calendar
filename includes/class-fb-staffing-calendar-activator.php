<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/barriofranz
 * @since      1.0.0
 *
 * @package    Fb_Staffing_Calendar
 * @subpackage Fb_Staffing_Calendar/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Fb_Staffing_Calendar
 * @subpackage Fb_Staffing_Calendar/includes
 * @author     Franz Ian Barrio <barriofranz@gmail.com>
 */
class Fb_Staffing_Calendar_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::fb_sc_install();
	}


	public function fb_sc_install() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;
		global $jal_db_version;



		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $wpdb->prefix . 'fb_sc_shift_type';
		$sql = "
		CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
			`shifttype_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`shifttype_name` varchar(128)
		) $charset_collate;

		INSERT INTO " . $table_name . " values (null,'RN');
		INSERT INTO " . $table_name . " values (null,'CNA');
		INSERT INTO " . $table_name . " values (null,'LPN');
		INSERT INTO " . $table_name . " values (null,'PSA');
		";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'fb_sc_locations';
		$sql = "
		CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
			`location_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`location_name` varchar(128)
		) $charset_collate;

		INSERT INTO " . $table_name . " values (null,'Canyon West');
		INSERT INTO " . $table_name . " values (null,'Valor');
		INSERT INTO " . $table_name . " values (null,'Cove');
		";
		dbDelta( $sql );


		$table_name = $wpdb->prefix . 'fb_sc_shift_schedules';
		$sql = "
		CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
			`shift_schedules_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`shift_schedules_location_id` int(11),
			`shift_schedules_shifttype_id` int(11),
			`shift_schedules_email` varchar(255),
			`shift_schedules_datefrom` date,
			`shift_schedules_timefrom` time,
			`shift_schedules_dateto` date,
			`shift_schedules_timeto` time
		) $charset_collate;

		";
		dbDelta( $sql );
	}

}
