<!DOCTYPE html>
<html lang="sv">
	<head>

	<!--Recommended Meta Tags-->
    <meta charset="utf-8">
	<meta name="language" content="english"> 
	<meta http-equiv="content-type" content="text/html">
    <meta name="author" content="Emanuel Olsson">
	<meta name="designer" content="Emanuel Olsson">
    <meta name="publisher" content="Emanuel Olsson">
    
    <!--Search Engine Optimization Meta Tags-->
    <title><?php wp_title( '|', true, 'right' ).' '. bloginfo('name'); ?></title>
    <meta name="description" content="Portfolio för webbutveckling">
    <meta name="keywords" content="Webbutvecklare, Webbdesigner, Wordpressutvecklare, Grafisk Formgivare, Front-end">
    <meta name="robots" content="index,follow">

	<!--Meta Tags for HTML pages on Mobile-->
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!--http-equiv Tags-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        
	<!--Scripts-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

		<?php if ( get_header_image() ) : ?>

			<div id="site-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( header_image() ); ?>" 
					width="<?php echo esc_attr( get_custom_header()->width ); ?>" 
					height="<?php echo esc_attr( get_custom_header()->height ); ?>" 
					alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				</a>
			</div>

		<?php endif; ?>

<?php wp_head();?>

</head>

<body <?php body_class(); ?>>

<div class="wrapper">
