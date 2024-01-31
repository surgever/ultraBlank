<?php
/**
 * UltraBlank functions and definitions
 *
 * @package WordPress
 * @subpackage ultrablank
 */

/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 * 
 */
function ultrablank_setup() {
	
	if ( ! isset( $content_width ) ) $content_width = 900;
	
	load_theme_textdomain( 'ultrablank', get_template_directory() . '/languages' );
	
	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'automatic-feed-links' );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus ( array (
		'primary' => 'Top primary menu'
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'caption'
	) );
}
add_action( 'after_setup_theme', 'ultrablank_setup' );

/**
 * Append page slugs to the body class
 * NB: Requires init via add_filter('body_class', 'add_slug_to_body_class');
 *
 * @param
 *        	array
 * @return array
 */
function ultrablank_bodyclasses($classes) {
	global $post;
	if (is_page () || is_singular ()) {
		$classes [] = sanitize_html_class ( $post->post_name );
	}
	return $classes;
}
add_filter ( 'body_class', 'ultrablank_bodyclasses' );

/**
 * Append page slugs to the body class
 * NB: Requires init via add_filter('body_class', 'add_slug_to_body_class');
 *
 * @param
 *        	array
 * @return array
 * @author Keir Whitaker
 */
function ultrablank_postclasses( $classes ) {
	if ( is_singular() ) {
		array_push( $classes, 'singular-post' );
	} else {
		array_push( $classes, 'archived-post' );
	}
	return $classes;
}
add_filter( 'post_class', 'ultrablank_postclasses' );

/**
 * Enqueue scripts and styles for the front end.
 */
function ultrablank_scripts() {
	wp_enqueue_style ( 'ultrablank-style', get_stylesheet_uri () );
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', ( 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js' ), false, null, true );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script ( 'comment-reply');
}
add_action ( 'wp_enqueue_scripts', 'ultrablank_scripts' );

/**
 * Registering a main sidebar
 */
function ultrablank_sidebar() {
	register_sidebar( array(
	'name' => __( 'Primary Sidebar', 'ultrablank' ),
	'id' => 'primary-sidebar',
	'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	) );
}
add_action( 'widgets_init', 'ultrablank_sidebar' );

/**
 * This is an example function for setting up post types
 */
/* * * * (Uncomment if need to add a custom post type ) * * * *
function ultrablank_posttype($basicname,$title,$icon = 'dashicons-book',$public=true) { // Generally title is the plural name
	if($public) $supports = array('title','editor','excerpt','thumbnail','revisions');
	else $supports = array('title','excerpt','thumbnail');
	$args = array(
			'labels' => array(
					'name' => $title,
					'singular_name' => ucfirst($basicname) ,
					'add_new' => "Add $basicname",
					'add_new_item' => "Add new $basicname",
					'new_item' => 'Add new' 
			),
			'label' => ucfirst($basicname),
			'public' => $public,
			'has_archive' => $public,
			'publicly_queryable' => $public,
			'show_ui' => true,
			'query_var' => $public,
			'menu_icon' => $icon,
			'rewrite' => array('slug' => $basicname, 'with_front' => false),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => $supports
	);
	register_post_type( $basicname , $args ); 
}
function ultrablank_define_posttypes() {
	ultrablank_posttype('slide','Home slider','dashicons-slides',false); //Slide post, titled 'Home Slider' in the dashboard, with a dashicon and not public
	//Custom taxonomies can be added here
}
add_action('init', 'ultrablank_define_posttypes');
* * * */

/**
 * Convert strings into colours
 * 
 * Useful for give a random chosen but permanent setted color to anything (posts, categories, etc...)
 */
function str_to_color($str) {
	return '#' . substr ( md5 ( $str ), 0, 6 );
}

/**
 * The compulsory thumbnail
 * 
 * Allows to always have an image even if the thumbnail is not defined.
 * Please, change the fallback for the default image
 */
function the_compulsory_thumbnail($size = 'thumbnail',$display = 'echo', $postid = false) {
	if(!$postid) $postid = get_the_ID();
	if ( has_post_thumbnail($postid) and $postid) {
		$id = get_post_thumbnail_id($postid);
	} else {
		/*Search img in content */
		$content = apply_filters('the_content',get_post_field('post_content', $postid));
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
		$found_imgurl = $matches[1][0];
		if(!$found_imgurl) {
			/*If no image present in content, get first attached image*/
			$attachments = get_children(array('post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order'));
			if ($attachments) {
				if ( is_array($attachments) ) {
					$count = count($attachments);
					$first_attachment = array_shift($attachments);
					$id = $first_attachment->ID;
				}
			}/* else { 
			$id = 1; // Fallback: set a default  images
			}*/
		}
	}
	if($display == 'echo') echo !$found_imgurl ? wp_get_attachment_image($id, $size) : '<img src="'.$found_imgurl.' alt="" />';
	elseif($display == 'return') {
		$src = !$found_imgurl ? wp_get_attachment_image_src($id, $size) : array($found_imgurl);
		return $src[0]; }
}

/**
 * Add a editor stylesheet
 *
 * A useful practice to bring theme custom stying to the wordpress editor
 */
function ultrablank_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}
add_action( 'after_setup_theme', 'ultrablank_add_editor_styles' );
