<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.azwgroup.co.ke/zach
 * @since      1.0.0
 *
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/includes
 * @author     Zach <plugins@azwgroup.co.ke>
 */
class Azw_Woocommerce_File_Uploads_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'azw-woocommerce-file-uploads',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
