<?php

/**
 * Plugin Name:       azw woocommerce file uploads
 * Plugin URI:        https://www.trendingfornow.com/zach/plugins/
 * Description:       The fastest, easiest and reliable way to allow customers to upload files to their orders, on the order received page
 *                    Vendors are also able to attach files for customers to their orders .
 * Version:           1.0.1
 * Author:            Zach
 * Author URI:        https://www.trendingfornow.com/zach/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


// check if woocommerce is active
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}
if ( !function_exists( 'wc_azw_fu' ) ) {
    // Create a helper function for easy SDK access.
    function wc_azw_fu()
    {
        global  $wc_azw_fu ;
        
        if ( !isset( $wc_azw_fu ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $wc_azw_fu = fs_dynamic_init( array(
                'id'             => '3196',
                'slug'           => 'azw-woocommerce-file-uploads',
                'type'           => 'plugin',
                'public_key'     => 'pk_a65251003c2d0c49c8d5096e2ac73',
                'is_premium'     => false,
                'premium_suffix' => 'pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'trial'          => array(
                'days'               => 7,
                'is_require_payment' => true,
            ),
                'menu'           => array(
                'slug'   => 'azw-woocommerce-file-uploads',
                'parent' => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'        => true,
            ) );
        }
        
        return $wc_azw_fu;
    }
    
    // Init Freemius.
    wc_azw_fu();
    // Signal that SDK was initiated.
    do_action( 'wc_azw_fu_loaded' );
}

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/** fired to activate the plugin **/
function activate_azw_woocommerce_file_uploads()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-azw-woocommerce-file-uploads-activator.php';
    Azw_Woocommerce_File_Uploads_Activator::activate();
}

/** fired to deactivate the plugin **/
function deactivate_azw_woocommerce_file_uploads()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-azw-woocommerce-file-uploads-deactivator.php';
    Azw_Woocommerce_File_Uploads_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_azw_woocommerce_file_uploads' );
register_deactivation_hook( __FILE__, 'deactivate_azw_woocommerce_file_uploads' );
require plugin_dir_path( __FILE__ ) . 'includes/class-azw-woocommerce-file-uploads.php';
require plugin_dir_path( __FILE__ ) . 'options.php';
function run_azw_woocommerce_file_uploads()
{
    $plugin = new Azw_Woocommerce_File_Uploads();
    $plugin->run();
}

run_azw_woocommerce_file_uploads();