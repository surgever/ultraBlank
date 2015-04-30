<?php if (!is_404() && have_posts()): while (have_posts()) : the_post(); ?>
<?php //Prepare post vars
	$singular = is_singular();
	$thumb = the_compulsory_thumbnail('large','return'); //force thumb just when force content
	unset($format_normal,$format_image);
	if(has_post_format('image')) $format_image = true;
	else $format_normal = true; //standard, aside, page...
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h1 class="post-title">
			<?php if(!$singular) echo "<a href=\"". esc_url( get_permalink() ) ."\">";?>
				<?php the_title(); ?>
			<?php if(!$singular) echo "</a>"; ?>
		</h1>
		<div class="post-content">
			<?php the_content(); ?>
		</div>
		<div class="post-meta clear">
			<?php edit_post_link('<span>'.__("Edit").' </span>');  ?> 
			<span class="date"><a href="<?php echo get_month_link('', ''); ?>"><?php echo date_i18n( get_option( 'date_format' ), get_the_time('U') ); ?></a></span> 
			<?php $category_list = '';
				foreach((get_the_category()) as $category) if (!in_array($category->cat_name, array(__('Uncategorized'),'Uncategorized')))
					$category_list .= '<a href="'.get_category_link( $category->term_id ).'" title="'.__('View Category').'" style="color:'.str_to_color($category->slug).'">'.$category->name.'</a> ';
				if($category_list) echo '<span class="categories">'.$category_list.'</span>'; ?> 
			<span class="author"><?php _e( 'Author' ); ?>: <?php the_author_posts_link(); ?>.</span> 
			<span class="commentslink"><?php $comment_text = '<i>%</i> <span>'.__("Comments").'</span>';
				if(!$singular && get_comments_number( get_the_ID() )) comments_popup_link('<i>0</i>','<i>1</i> <span>'.__("Comment").'</span>',$comment_text,'comments-link');?></span>
			<?php the_tags('<br />'.__("Tags: "), ', '); ?>
		</div>						
		<?php wp_link_pages(array('before' => '<div class="post-pages">'.__('Pages:'),'after' => '</div>', 'next_or_number' => 'number')); ?>
		<?php if($singular) comments_template(); ?>
	</article>
<?php endwhile; ?>

<?php else: ?>
	<article id="post-notfound" <?php post_class(); ?>>
		<h1><?php if(is_404()) echo 'Error 404:'; ?> Not found</h1>
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'ultrablank' ); ?></p>
		<div class="search-area"><?php get_search_form(); ?></div>
		<br />
	</article>
<?php endif; ?>