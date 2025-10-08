<?php
ob_start();
date_default_timezone_set("GMT");

if(!function_exists('grapefruit_setup')){
	function grapefruit_setup(){
		load_theme_textdomain('grapefruit', get_template_directory() . '/languages');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');

		register_nav_menus(array(
			'primary' => esc_html__('Primary', 'grapefruit'),
		));

		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		add_theme_support('custom-background', apply_filters('grapefruit_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => ''
		)));
	}
	add_action('after_setup_theme', 'grapefruit_setup');
}
/*
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function grapefruit_content_width() {
	$GLOBALS['content_width'] = apply_filters('grapefruit_content_width', 640);
}
add_action('after_setup_theme', 'grapefruit_content_width', 0);
/*
 * Register widget area.
 */
function grapefruit_widgets_init(){
	register_sidebar( array(
		'name'          => esc_html__('Sidebar', 'grapefruit'),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'grapefruit' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action('widgets_init', 'grapefruit_widgets_init');

/* Root of Theme */
define('ROOT', dirname(__FILE__) . '/');

/* Load Configuration File */
require_once ROOT . 'inc/config/site.php';

/* Load Required Engine Files */
require_once ROOT . 'inc/engine/config.php';
require_once ROOT . 'inc/engine/router.php';
require_once ROOT . 'inc/engine/app.php';
require_once ROOT . 'inc/engine/init.php';

list($app) = init();

// Admin Loaders
if(is_user_logged_in()){
	//-> Load WP Post Layouts
	$_layout = $app->loader('_layout');

	//-> Load WP Post Title Bars
	$_titlebar = $app->loader('_titlebar');

	//-> Load WP Post Page Type
	$_page_type = $app->loader('_page_type');
}

// Theme Loaders
//-> Load Shortcodes
$shortcodes = $app->loader('shortcodes');
$shortcodes->load_shortcodes();

// -> Load Plugins Settings
$plugins = $app->loader('plugins');

// -> Load Post Settings
$posts = $app->loader('posts');