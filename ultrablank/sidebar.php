<aside id="sidebar">

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('primary-sidebar') ) : ?>
		<div class="widget widget_search">
			<?php get_search_form(); ?>
		</div>
		<div class="widget widget-recent-posts">
			<h3 class="widget-title"><?php _e( 'Recent Posts' ); ?></h3>
			<ul>
				<?php $recent_posts = wp_get_recent_posts();
					foreach( $recent_posts as $recent )
					echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
				?>
			</ul>
		</div>
		<div class="widget">
			<h3 class="widget-title"><?php _e( 'Archives' ); ?></h3>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>
		</div>
		<div class="widget">
			<h3 class="widget-title"><?php _e( 'Categories' ); ?></h3>
			<ul>
				<?php wp_list_categories('title_li='); ?>
			</ul>
		</div>
		<div class="widget">
			<h3 class="widget-title"><?php _e( 'Meta'); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</div>
	<?php endif; ?>	
</aside>