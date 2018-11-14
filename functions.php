<?php
/**********************************************************************************
theme_setup - sets up themes
- registers default headers
- defining variable and shortcode for easy pathing and contact form
- adds theme supports
- registers and enqueues css/js/fonts
- function for sending mail using the ajax contact form
- registers and adds custom menu to wp-admin
- adds extra custom settings menu to wp-admin

**********************************************************************************/

function theme_setup() {

/**********************************************************************************	
 Enabling error-reporting for troubleshooting
**********************************************************************************/

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
	

/**********************************************************************************	
  Registering default headers. Needed for adding theme_support for custom headers
**********************************************************************************/

	register_default_headers( array(
		'portfolio'		=> array(
		'url'			=> get_template_directory_uri() . '/images/headers/header_portfolio.png',
		'thumbnail_url' => get_template_directory_uri() . '/images/headers/header_portfolio_thumbnail.png',
		'description'   => __( 'portfolio', 'emcolsson' )
	)
) );



/**********************************************************************************	
	Defining the variable 'THEME_IMG_PATH' for easier access to image directory
**********************************************************************************/

	/* Setting variable 'THEME_IMG_PATH' that points to theme root/images */
	
    define( 'THEME_IMG_PATH', get_template_directory_uri() . '/images' );

	/* Adds shortcode get_template_directory_uri that poitns to same directory, used with [] from WP-admin  */
	add_shortcode('get_template_directory_uri', 'get_template_directory_uri');
	


/**********************************************************************************	
  Creating shortcode for the contact form as [AjaxContactForm]
**********************************************************************************/	

function createAjaxContactForm() {

return '
<div id="form-response">
</div>
<form class="contact-form" method="post" action="" id="ajaxContactForm">
<div class="upper-form">
<div class="contact-input"><input type="text" id="name" placeholder="Your name" required></div>
<div class="contact-input"><input type="email" id="mail" placeholder="Your mail" required></div>
</div>
<div class="contact-input"><textarea id="message" placeholder="Your message" rows="10" required></textarea></div>
<div class="lower-form">
<div class="contact-input"><span class="status"></span></div>
<div class="contact-input"><input id="submitButton" type="submit" value="Send"></div>
</div>
</form>
';
}
add_shortcode('AjaxContactForm', 'createAjaxContactForm');



/**********************************************************************************	
		Adding different theme_support - enables extra wp-admin options.
**********************************************************************************/

	/* Custom Title-tag */
	add_theme_support( 'title-tag' );

	/* Custom Thumbnails */
	add_theme_support( 'post-thumbnails' );

	/* Adding support for custom header and setting a default one */
	$headerinfo = array(
	'default-color'			=> '000000',
	'default-image'			=> get_template_directory_uri() . '/images/headers/header_portfolio.png',
	'flex-height'			=> true,
	'flex-width'			=> true,
	'width'					=> 1400,
	'height'				=> 140,
	'uploads'				=> true,
	'random-default'		=> false,
	'header-text'			=> false,

);
add_theme_support( 'custom-header', $headerinfo );

	/* Adding support for custom background and setting a default one */
	$backgroundinfo = array(
	'default-color' => '000000',
	'default-image' => get_template_directory_uri() . '/images/backgrounds/bg4.png',

);
add_theme_support( 'custom-background', $backgroundinfo );



/**********************************************************************************	
  Registering, enqueuing and localizing scripts
**********************************************************************************/	
	
wp_enqueue_script('jquery');

function contact_form_scripts() {
	if (is_page('contact')) {
		wp_register_script( 'ajaxrequest', get_template_directory_uri() . '/js/contactform_ajaxrequest.js', array( 'jquery' ), false, true );
		wp_enqueue_script ( 'ajaxrequest' );
		wp_localize_script( 'ajaxrequest', 'MyAjax', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce( "ajax-contact-nonce" ) ) );	
	}
}
add_action( 'wp_enqueue_scripts', 'contact_form_scripts' );



/**********************************************************************************	
		Registering and (needed to->) enqueuing stylesheets and font 
**********************************************************************************/

function theme_styles(){	

	/* Register css */
	wp_register_style( 'theme_style', get_template_directory_uri() . '/css/theme_style.css' );
	wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );

	/* Loading/enqueuing css (normalize automatically enqueued when added as an condition to the enqueuing of theme_style */
	wp_enqueue_style( 'theme_style', array( 'normalize' ) );

	/* Register Open Sans font */
	wp_register_style('OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');

	/* Loading Open Sans font */
	wp_enqueue_style( 'OpenSans');
}
add_action( 'wp_enqueue_scripts', 'theme_styles' );



/**********************************************************************************	
  Part of AJAX contact form solution, gets ajax request, sends mail and return info
**********************************************************************************/	
function parser_callback() {

	//wp_send_json_error( 'You suck!' ); // to see if the ajax request to parser is successfully sent.
	
	if ( ! check_ajax_referer( 'ajax-contact-nonce', 'nonce' ) ) { // to see if nonce checks out
		return wp_send_json_error( 'Invalid nonce' );
	}

if ( isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['message']) ) { 
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $message = nl2br($_POST['message']);
	$to = "<manneolsson@hotmail.com>";
    $from = "<$mail>";
    $subject = 'Kontaktformulär från emcolsson.se ifyllt';
	$message = '<b>Name:</b> '.$name.' <br><b>Email:</b> '.$mail.' <p>'.$message.'</p>';
	$headers = "From: $from" . "\r\n" . "Reply-to: $mail" . "\r\n" . "X-Mailer: PHP/" . phpversion();
    $headers .= "MIME-version: 1.0\n";
	$headers .= "Content-Type: text/html; charset=utf-8\n"; //Fixes ÅÄÖ in Sender name and Message
	
  
    if( mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $headers) ) { //Fixes ÅÄÖ in subject 
        echo "success"; 
         
    } else { 
        echo "The server failed to send the message. Please try again later."; 
    } 
} 
exit();
}
add_action( 'wp_ajax_parser', 'parser_callback' );
add_action( 'wp_ajax_nopriv_parser', 'parser_callback' );



/**********************************************************************************	
			Registering and adding custom menus to wp-admin
**********************************************************************************/

function register_my_menus() {
	register_nav_menus(
		array(
			'header-menu'	=> __( 'Main Menu' ),
			'cv-menu' 		=> __( 'CV Menu' )
	)
  );
}
add_action( 'init', 'register_my_menus' );



/**********************************************************************************	
				Adding WP-admin "Custom settings" menu
**********************************************************************************/

function custom_settings_add_menu() {
	add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings', 'custom_settings_page', null, 99 );
}
add_action( 'admin_menu', 'custom_settings_add_menu' );



/**********************************************************************************	
					Create Custom Global Settings 
**********************************************************************************/	

	/* Layout for input page */
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
<?php }

	/* Input fields for social media */
function setting_twitter() { ?>
<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_option( 'twitter' ) ); ?>" />
<?php }
function setting_facebook() { ?>
<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_option('facebook') ); ?>" />
<?php }
function setting_linkedin() { ?>
<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_option('linkedin') ); ?>" />
<?php }

	/* Input labels and holders for registering the input */
function custom_settings_page_setup() {
	add_settings_section( 'section', 'All Settings', null, 'theme-options' );
	add_settings_field( 'twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'section' );
	add_settings_field( 'facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'section' );
	add_settings_field( 'linkedin', 'Linkedin URL', 'setting_linkedin', 'theme-options', 'section' );

	register_setting('section', 'twitter');
	register_setting('section', 'facebook');
	register_setting('section', 'linkedin');
}
add_action( 'admin_init', 'custom_settings_page_setup' );



/**********************************************************************************	
	Creating a custom menu and field for attaching images by extending original walker
**********************************************************************************/	

class custom_menu {
	
	/**
 * Define new Walker edit
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function edit_walker($walker,$menu_id) {

	return 'Walker_Nav_Menu_Edit_Custom';

}

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
function __construct() {
	
	/* add custom menu fields to menu */
	add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_nav_fields' ) );
	
	/* save menu custom fields */
	add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_nav_fields'), 10, 3 );
	
	/* edit menu walker */
	add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker'), 10, 2 );

	} 
		
	/* End constructor */

	/* All functions will be placed here */
function add_custom_nav_fields( $menu_item ) {

	$menu_item->image = get_post_meta( $menu_item->ID, '_menu_item_image', true );
	return $menu_item;

}

/**
 * Save menu custom fields
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

	/* Check if element is properly sent */
	if ( is_array( $_REQUEST['menu-item-image']) ) {
		$image_value = $_REQUEST['menu-item-image'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, '_menu_item_image', $image_value );
	}
}

	/* End class */
}

	/* instantiate custom_menu class */
$GLOBALS['custom_menu'] = new custom_menu();

include_once( 'edit_custom_walker.php' );
include_once( 'custom_walker.php' );



/**********************************************************************************	
		End of functions, now calling the main function theme_setup()
**********************************************************************************/	

}
add_action( 'after_setup_theme', 'theme_setup' );
