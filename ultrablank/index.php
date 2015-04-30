<?php get_header(); ?>	

	<?php if(!is_singular() && !is_front_page()) get_template_part('title'); ?>

	<main role="main">
			<?php get_template_part('loop'); ?>
			<?php get_template_part('pagination'); ?>
	</main>

<?php get_sidebar(); ?>
	
<?php get_footer(); ?>