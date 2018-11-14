<!-- This will always display the Home page, no matter what is set in admin panel as static or not -->

<?php
/*
Template Name: Homepage Template Page
Description: Gives Home its look. Big menu and no other content.
*/

get_header(); 

	wp_nav_menu( array(
		'menu' => 'main-menu',
		'menu_class' => 'menu',
		'menu_id' => 'menu-list-ul',
		'container' => 'nav',
		'container_class' => 'menu-container',
		'container_id' => 'menu-container',
		'walker' => new rc_scm_walker	
	)
); 

get_footer();

?>
