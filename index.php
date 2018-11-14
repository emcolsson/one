<!-- index.php functions as a last resport fallback - if no other template is found this is loaded. If for example a new page is added with no template bound to it, this would automtically assign itself -->
<?php 

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


	

