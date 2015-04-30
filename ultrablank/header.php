<?php
if(!$_GET["callback"]) { ?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<!--[if lt IE 9]><script src="<?php echo get_stylesheet_directory_uri() ?>/js/html5shiv.js"></script><script>var ie8=1;</script><![endif]-->
</head>
<body <?php body_class(); ?> data-url="http://<?php echo $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']; ?>">
	<header class="header">
		<div class="wrapper">	
			<div id="logo">
				<?php $logotype = '<img src="'.get_stylesheet_directory_uri().'/img/logo.png" alt="logo" /> <strong>'.get_bloginfo('name').'</strong>';
					if(is_front_page() AND !$paged) echo '<h1 id="site-title">'.$logotype.'</h1>';
				 	else echo '<a id="site-title" href="'.home_url().'/">'.$logotype.'</a>';
				 ?>
			</div>
			<nav id="primary-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>
		</div>
	</header>
	<div id="content" class="wrapper">
<?php
} else {
	$data['title'] = wp_title(false,false);
	$data['bodyclasses'] = implode(' ',get_body_class($class));
	ob_start();
}
