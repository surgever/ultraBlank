<div class="comments">

	<?php if (post_password_required()) : ?>
	<p><?php _e( 'This content is password protected. To view it please enter your password below:' ); ?></p>
</div>
<?php return; endif; ?>

<?php if (have_comments()) { ?>
	<h2><?php comments_number(); ?></h2>
	<ul><?php wp_list_comments('type=comment'); ?></ul>
	<?php paginate_comments_links(); ?>
<?php } elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
	<p><?php _e( 'Comments are closed.', 'ultrablank' ); ?></p>
<?php } ?>

<?php comment_form(); ?>

</div>
