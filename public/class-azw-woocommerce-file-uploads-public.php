<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.azwgroup.co.ke/zach
 * @since      1.0.0
 *
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Azw_Woocommerce_File_Uploads
 * @subpackage Azw_Woocommerce_File_Uploads/public
 * @author     Zach <plugins@azwgroup.co.ke>
 */
class Azw_Woocommerce_File_Uploads_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    /** function upload file and display uploaded files on orders page
    */
    public function azw_order_received_page_upload_file( $order_id )
    {
        echo  '<form name="uploadfile" action="" method="post" enctype="multipart/form-data">
                  <h2 style="color: #6600ff;">Upload a file to your order</h2>
                  <label for="fileSelect">Filename:</label>
                  <input type="file" name="application" id="fileSelect"></br></br>
                  <input type="submit" name="upload-submit" style ="color: #0000ff; background-color: #ffff99" value="Upload">
                  <p><strong>Note:</strong> Only .pdf formats allowed to a max size of 5 MB.</p>
                  </form>' ;
        
        if ( !empty($_POST['upload-submit']) ) {
            global  $wp ;
            $order_id = absint( $wp->query_vars['order-received'] );
            $uploads_folder = WP_CONTENT_DIR . '/uploads/azw-uploads/';
            $order = wc_get_order( $order_id );
            $order_data = $order->get_data();
            $order_status = $order_data['status'];
            // Check if file was uploaded without errors
            
            if ( isset( $_FILES["application"] ) && $_FILES["application"]["error"] == 0 ) {
                $allowed = array(
                    "pdf" => "application/pdf",
                );
                // to sanitize the filename
                $filename = sanitize_file_name( $_FILES["application"]["name"] );
                // check and validate the file type
                $ext = pathinfo( $filename, PATHINFO_EXTENSION );
                
                if ( !array_key_exists( $ext, $allowed ) ) {
                    ?>
                    <script>
                        if ( window.history.replaceState ) {
                          window.history.replaceState( null, null, window.location.href );
                        }
                        </script> 
            <?php 
                    die( "Error: Please select a valid file type." );
                }
                
                global  $newfilename ;
                $newfilename = sanitize_file_name( $order_id . ' cust ' . $filename );
                // restrict the uploaded file size to 5MB
                $maxsize = 5 * 1024 * 1024;
                
                if ( $_FILES["application"]["size"] > $maxsize ) {
                    ?>
                    <script>
                        if ( window.history.replaceState ) {
                          window.history.replaceState( null, null, window.location.href );
                        }
                        </script>  
         <?php 
                    die( "Error: File size is larger than the allowed limit." );
                }
                
                // Now to verify the MIME type of the file
                $filetype = $_FILES["application"]["type"];
                // filetype checked and validated on lines 61-63 above
                
                if ( in_array( $filetype, $allowed ) ) {
                    // Check whether file exists before uploading it
                    
                    if ( file_exists( $uploads_folder . $newfilename ) ) {
                        echo  '<b>' . esc_html( $newfilename ) . '</b>' . " already exists.</br>" ;
                        ?>
                <script>
                    if ( window.history.replaceState ) {
                      window.history.replaceState( null, null, window.location.href );
                    }
                    </script>
                 
           <?php 
                    } else {
                        move_uploaded_file( $_FILES["application"]["tmp_name"], $uploads_folder . $newfilename );
                        echo  "Your file was uploaded successfully.</br>" ;
                        ?>
                             <script>
                                if ( window.history.replaceState ) {
                                  window.history.replaceState( null, null, window.location.href );
                                }
                                </script>                  
          <?php 
                    }
                
                } else {
                    ?>
                    <script>
                    if ( window.history.replaceState ) {
                      window.history.replaceState( null, null, window.location.href );
                    }
                    </script> 
    <?php 
                    die( "Error: There was a problem uploading your file. Please try again." );
                }
            
            } else {
                ?>
        <script>
            if ( window.history.replaceState ) {
              window.history.replaceState( null, null, window.location.href );
            }
            </script>
   <?php 
                die( "Error: " . esc_html( $_FILES["application"]["error"] ) );
            }
        
        }
    
    }
    
    public function display_uploaded_files( $order_id )
    {
        /** now to display the uploaded files on the order page, the following code is called
         **/
        echo  "<h3><u><b><span style='color: #0000ff;'>Uploaded files Section</span></u></b></h3><br>" ;
        echo  "<h3><u><b><span style='color: #ff0000;'>My attached files</span></u></b></h3>" ;
        $uploads_folder_url = WP_CONTENT_URL . '/uploads/azw-uploads/';
        $uploads_folder = WP_CONTENT_DIR . '/uploads/azw-uploads/';
        $files = preg_grep( '~^' . $order_id . '-cust-' . '.*\\.(pdf)$~', scandir( $uploads_folder ) );
        foreach ( $files as $file ) {
            $file = $file;
            echo  esc_html( $file ) . '</br>' ;
            echo  "<a href=" . esc_url( $uploads_folder_url . $file ) . ' /target="_blank">' . '</br>Download.</a></br></br>' ;
        }
        // show the attached files by vendor
        echo  '<h3><u><b><span style="color: #00cc00;">Attached files by Seller</span></u></b></h3>' ;
        $files = preg_grep( '~^' . $order_id . '-vend-' . '.*\\.(pdf)$~', scandir( $uploads_folder ) );
        foreach ( $files as $file ) {
            $file = $file;
            echo  esc_html( $file ) . '</br>' ;
            echo  "<a href=" . esc_url( $uploads_folder_url . $file ) . ' /target="_blank">' . '</br>Download.</a></br></br>' ;
        }
    }
    
    public function azw_woocommerce_vendor_upload_files( $order_id )
    {
        $order = wc_get_order( $order_id );
        $order_data = $order->get_data();
        $order_status = $order_data['status'];
        
        if ( $order_status == "processing" ) {
            echo  '<form name="vendorupload" action="" method="post" enctype="multipart/form-data">
            <br><h2 style="color: #6600ff;">Upload a file to your order</h2><br><br>
           <label align="right">Filename:</label><br>
           <input type="file" name="application" id="fileSelect">' . '</br></br>
           <input type="submit" name="vendor-submit" style ="color: #0000ff; background-color: #ffff99" value="Upload">
           <p><strong>Note:</strong> Only .pdf formats allowed to a max size of 5 MB.</p>
           </form>
           ' ;
        } else {
        }
        
        // Check if the form was submitted
        //  if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if ( !empty($_POST['vendor-submit']) ) {
            $uploads_folder = WP_CONTENT_DIR . '/uploads/azw-uploads/';
            // Check if file was uploaded without errors
            
            if ( isset( $_FILES["application"] ) && $_FILES["application"]["error"] == 0 ) {
                $allowed = array(
                    "pdf" => "application/pdf",
                );
                // to sanitize the filename
                $filename = sanitize_file_name( $_FILES['application']['name'] );
                // check and validate the file type
                $ext = pathinfo( $filename, PATHINFO_EXTENSION );
                
                if ( !array_key_exists( $ext, $allowed ) ) {
                    ?>
                    <script>
                        if ( window.history.replaceState ) {
                          window.history.replaceState( null, null, window.location.href );
                        }
                        </script>
             <?php 
                    die( "Error: Please select a valid file format." );
                }
                
                global  $vendorfilename ;
                $vendorfilename = sanitize_file_name( $order_id . ' vend ' . $filename );
                // restrict the uploaded file size to 5MB
                $maxsize = 5 * 1024 * 1024;
                
                if ( $_FILES["application"]["size"] > $maxsize ) {
                    ?>
                    <script>
                    if ( window.history.replaceState ) {
                      window.history.replaceState( null, null, window.location.href );
                    }
                    </script>
      <?php 
                    die( "Error: File size is larger than the allowed limit." );
                }
                
                // Now to verify the MIME type of the file
                $filetype = $_FILES["application"]["type"];
                
                if ( in_array( $filetype, $allowed ) ) {
                    // Check whether file exists before uploading it
                    
                    if ( file_exists( $uploads_folder . $vendorfilename ) ) {
                        echo  '<b>' . esc_html( $vendorfilename ) . '</b>' . " already exists.</br>" ;
                        ?>
                
                <script>
                    if ( window.history.replaceState ) {
                      window.history.replaceState( null, null, window.location.href );
                    }
                    </script>
        <?php 
                    } else {
                        move_uploaded_file( $_FILES["application"]["tmp_name"], $uploads_folder . $vendorfilename );
                        echo  "Your file was uploaded successfully.</br>" ;
                        ?>
                        <script>
                            if ( window.history.replaceState ) {
                              window.history.replaceState( null, null, window.location.href );
                            }
                            </script>
        <?php 
                    }
                
                } else {
                    ?>
                    <script>
                    if ( window.history.replaceState ) {
                      window.history.replaceState( null, null, window.location.href );
                    }
                    </script>
    <?php 
                    die( "Error: There was a problem uploading your file. Please try again." );
                }
            
            } else {
                ?>
        <script>
            if ( window.history.replaceState ) {
              window.history.replaceState( null, null, window.location.href );
            }
            </script>
   <?php 
                die( "Error: " . esc_html( $_FILES["application"]["error"] ) );
            }
        
        }
    
    }
    
    public function display_vendor_uploaded_files( $order_id )
    {
        /** now to display the uploaded files on the order page, the following code is called
         **/
        // now the files uploaded by the customer
        echo  "<h3><u><b><span style='color: #0000ff;'>Uploaded files Section</span></u></b></h3><br>" ;
        echo  '<h3><u><b><span style="color: #ff0000;">Customer files</span></b></u></h3>' ;
        $uploads_folder = WP_CONTENT_DIR . '/uploads/azw-uploads/';
        $uploads_folder_url = WP_CONTENT_URL . '/uploads/azw-uploads/';
        $files = preg_grep( '~^' . $order_id . '-cust-' . '.*\\.(pdf)$~', scandir( $uploads_folder ) );
        foreach ( $files as $file ) {
            $file = $file;
            echo  esc_html( $file ) . '</br>' ;
            echo  "<a href=" . esc_url( $uploads_folder_url . $file ) . ' /target="_blank">' . '</br>Download.</a></br></br>' ;
        }
        // show the attached files by vendor
        echo  '<h3><u><b><span style="color: #00cc00;">My attached files</span></u></b></h3>' ;
        $files = preg_grep( '~^' . $order_id . '-vend-' . '.*\\.(pdf)$~', scandir( $uploads_folder ) );
        foreach ( $files as $file ) {
            $file = $file;
            echo  esc_html( $file ) . '</br>' ;
            echo  "<a href=" . esc_url( $uploads_folder_url . $file ) . ' /target="_blank">' . '</br>Download.</a></br></br>' ;
        }
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/azw-woocommerce-file-uploads-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/azw-woocommerce-file-uploads-public.css',
            array(),
            $this->version,
            'all'
        );
    }

}