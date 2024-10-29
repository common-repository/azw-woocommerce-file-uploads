<?php
add_action( 'admin_menu', 'azw_add_admin_menu' );
add_action( 'admin_init', 'azw_settings_init' );


function azw_add_admin_menu(  ) { 

	add_options_page( 'options-general.php', 'azw woocommerce file uploads', 'manage_options', 'azw-woocommerce-file-uploads', 'azw_options_page' );

}


function azw_settings_init(  ) { 

	register_setting( 'azw-woocommerce-file-uploads', 'azw_settings' );

	add_settings_section(
		'azw_azw-woocommerce-file-uploads_section', 
		__( 'Upload page settings', 'azw' ), 
		'azw_settings_section_callback', 
		'azw-woocommerce-file-uploads'
	);

	add_settings_field( 
		'azw_checkbox_field_0', 
		__( 'Order Received Page', 'azw' ), 
		'azw_checkbox_field_0_render', 
		'azw-woocommerce-file-uploads', 
		'azw_azw-woocommerce-file-uploads_section' 
	);

	add_settings_field( 
		'azw_checkbox_field_1', 
		__( 'View Order Page', 'azw' ), 
		'azw_checkbox_field_1_render', 
		'azw-woocommerce-file-uploads', 
		'azw_azw-woocommerce-file-uploads_section' 
	);


}


function azw_checkbox_field_0_render(  ) { 

	$options = get_option( 'azw_settings' );
	?>
	<input type='checkbox' name='azw_settings[azw_checkbox_field_0]' <?php checked( $options['azw_checkbox_field_0'], 1 ); ?> value='1'>
	<?php

}


function azw_checkbox_field_1_render(  ) { 

	$options = get_option( 'azw_settings' );
	?>
	<input type='checkbox' name='azw_settings[azw_checkbox_field_1]' <?php checked( $options['azw_checkbox_field_1'], 1 ); ?> value='1'>
	<?php

}


function azw_settings_section_callback(  ) { 

	echo __( 'Check the upload page(s)', 'azw' );

}


function azw_options_page(  ) { 

	?>
	<form action="options.php" method='post'>

		<h2>Azw Woocommerce File Uploads</h2>

		<?php
		settings_fields( 'azw-woocommerce-file-uploads' );
		do_settings_sections( 'azw-woocommerce-file-uploads' );
		submit_button();
		?>

	</form>
	<?php

}

?>