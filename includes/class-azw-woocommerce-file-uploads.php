<?php

/**
 * @link       www.azwgroup.co.ke/zach
 * @since      1.0.0
 *
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/includes
 * @author     Zach <plugins@azwgroup.co.ke>
 */
class Azw_Woocommerce_File_Uploads
{
    protected  $loader ;
    protected  $plugin_name ;
    protected  $version ;
    public function __construct()
    {
        
        if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
            $this->version = PLUGIN_NAME_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        
        $this->plugin_name = 'azw-woocommerce-file-Uploads';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
    
    private function load_dependencies()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-azw-woocommerce-file-uploads-loader.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-azw-woocommerce-file-uploads-i18n.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-azw-woocommerce-file-uploads-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-azw-woocommerce-file-uploads-public.php';
        $this->loader = new Azw_Woocommerce_File_Uploads_Loader();
    }
    
    private function set_locale()
    {
        $plugin_i18n = new Azw_Woocommerce_File_Uploads_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    private function define_admin_hooks()
    {
        $plugin_admin = new Azw_Woocommerce_File_Uploads_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    }
    
    private function define_public_hooks()
    {
        $plugin_public = new Azw_Woocommerce_File_Uploads_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_filter(
            'after_wcfm_orders_details_items',
            $plugin_public,
            'azw_woocommerce_vendor_upload_files',
            11
        );
        $this->loader->add_filter(
            'woocommerce_view_order',
            $plugin_public,
            'display_uploaded_files',
            12
        );
        $this->loader->add_filter(
            'after_wcfm_orders_details_items',
            $plugin_public,
            'display_vendor_uploaded_files',
            12
        );
        $this->loader->add_action(
            'woocommerce_thankyou',
            $plugin_public,
            'azw_order_received_page_upload_file',
            11
        );
    }
    
    public function run()
    {
        $this->loader->run();
    }
    
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    public function get_loader()
    {
        return $this->loader;
    }
    
    public function get_version()
    {
        return $this->version;
    }

}