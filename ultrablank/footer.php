<?php
if(!$_GET["callback"]) { ?>
	</div>
<footer>
	<div class="wrapper">
		<p class="copyright">
			<?php echo date('Y - '); bloginfo('name'); ?>.
			<?php echo sprintf(__('Proudly powered by %s', 'ultrablank'),'<a href="//wordpress.org" title="WordPress">WordPress</a> &amp; <a href="//surgever.com/ultrablank" title="Ultra Blank">Ultra Blank</a>.'); ?>
		</p>
	</div>
	<?php wp_footer(); ?>
</footer>
	</body>
</html>
<?php 
} else {
	$data['contents'] = preg_replace(array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'), array('>','<','\\1'),ob_get_contents());
	ob_end_clean();
    echo $_GET["callback"].'('.json_encode($data).');';
}