<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/includes
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */
class Wjf_Portfolio_Activator {


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wjf-portfolio-admin.php';

        Wjf_Portfolio_Admin::new_cpt_portfolio();
        Wjf_Portfolio_Admin::new_cpt_taxonomy_type();

        flush_rewrite_rules();

	}

}