<?php
function theme_styles(){	
/* Add scripts, stylesheets and fonts */
	
	/* Register css */
	wp_register_style( 'blog', get_template_directory_uri() . '/css/blog.css' );
	wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
	
	
	/* Loading/enqueuing css */
	wp_enqueue_style( 'blog', array( 'normalize' ) );
	
	/* Register Open Sans font */
	wp_register_style('OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');
	
	/* Loading Open Sans font */
	wp_enqueue_style( 'OpenSans');
}
add_action( 'wp_enqueue_scripts', 'theme_styles' );
?>