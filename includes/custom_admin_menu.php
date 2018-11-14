	/* Adding WP admin Custom settings menu */
    
function custom_settings_add_menu() {
  		add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings', 'custom_settings_page', null, 99 );
}
		add_action( 'admin_menu', 'custom_settings_add_menu' );
	}
    
    			// Create Custom Global Settings
function custom_settings_page() { ?>
  <div class="wrap">
    <h1>Custom Settings</h1>
    <form method="post" action="options.php">
       <?php
           settings_fields( 'section' );
           do_settings_sections( 'theme-options' );      
           submit_button(); 
       ?>          
    </form>
  </div>
<?php 