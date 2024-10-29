<?php

/**
 * Fired during plugin activation
 *
 * @link       www.azwgroup.co.ke/zach
 * @since      1.0.0
 *
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/includes
 * @author     Zach <plugins@azwgroup.co.ke>
 */
class Azw_Woocommerce_File_Uploads_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	   $dirname = $_POST['search'];
	   $filename =WP_CONTENT_DIR."/uploads/azw-uploads/";
	   if (!file_exists($filename)) {
	       mkdir(WP_CONTENT_DIR.'/uploads/azw-uploads');
	       exit;
	   }
	   
        
	}

}



