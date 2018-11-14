<?php
/*
Template Name: Page Template Page
Description: Gives all pages with this template chosen the look of the theme containing header, footer.
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

	if (have_posts()) :
		while (have_posts()) :
			the_post();
			?>
            <div class="content-container">
            <?php
			the_content();
			?>
            </div>
            <?php
		endwhile;
	endif;

get_footer();

?>
