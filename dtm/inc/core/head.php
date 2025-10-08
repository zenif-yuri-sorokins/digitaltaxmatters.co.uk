<?php
class Head extends App{
	function _construct(){
		// Clean Head
		$this->clean_head();

		// Load CSS & JS Files
		$this->enqueue_files();

		// Put If Modified Since to Headers
		$this->if_modified_since();

		// Remove Type Attributes from Styles & Script Tags
		$this->filter_type_attr();
	}
	// Clean Unwanted HTML From <head>
	private function clean_head(){
		// Category Feeds
		remove_action('wp_head', 'feed_links_extra', 3);

		// Post and Comments Feed
		remove_action('wp_head', 'feed_links', 2);

		// Remove DSN Prefetch
		remove_action('wp_head', 'wp_resource_hints', 2);

		// Only required if you are looking to blog using an external tool
		remove_action('wp_head', 'rsd_link');

		// Something to do with windows live writer
		remove_action('wp_head', 'wlwmanifest_link');

		// Next previous post links
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

		// Short links like ?p=124
		remove_action('wp_head', 'wp_shortlink_wp_head');

		// Remove Emoji CSS and JS from head
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');

		// Remove Generator Tags
		remove_action('wp_head', 'wp_generator');

		// Remove WP JSON
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
		remove_action('wp_head', 'rest_output_link_wp_head');
	}
	// Load Important Head Tags
	public function ie_html_tags(){
		$html  = '<!--[if IE 7]>';
		$html .= '<html class="ie ie7" lang="en-GB" prefix="og:http://ogp.me/ns#">';
		$html .= '<![endif]-->';
		$html .= '<!--[if IE 8]>';
		$html .= '<html class="ie ie8" lang="en-GB" prefix="og:http://ogp.me/ns#">';
		$html .= '<![endif]-->';
		$html .= '<!--[if !(IE 7) & !(IE 8)]><!-->';

		return $html;
	}
	// Load Important Head Tags
	public function head_tags(){
		$html  = '<meta charset="'. $this->config->read('meta/charset') .'" />';
		$html .= '<meta name="viewport" content="'. $this->config->read('meta/viewport') .'" />';
		$html .= '<link rel="profile" href="http://gmpg.org/xfn/11" />';

		return $html;
	}
	// Load IE Scripts
	public function pingback(){
		if(is_singular() && pings_open(get_queried_object())){
			return '<link rel="pingback" href="'. $this->config->read("pingback_url") .'" />';
		}
	}
	// Load Favicons
	public function load_favicons(){
		$html  = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon/favicon.ico" type="image/x-icon" />';

		// Load Apple Icons
		foreach($this->config->read('theme/favicons/apple') as $size){
			$html .= '<link rel="apple-touch-icon" sizes="'. $size .'" href="'. get_template_directory_uri() .'/images/favicon/apple-touch-icon-'. $size .'.png" />';
		}

		// Load Apple Icons
		foreach($this->config->read('theme/favicons/ms') as $size){
			$html .= '<meta name="msapplication-TileImage" content="'. get_template_directory_uri() .'/images/favicon/favicon-'. $size .'.png" />';
		}

		$html .= '<meta name="application-name" content="'. $this->config->read('company/name') .'" />';
		$html .= '<meta name="msapplication-TileColor" content="'. $this->config->read('theme/favicons/tile_colour') .'" />';

		return $html;
	}
	// Load IE Scripts
	public function load_ie_scripts(){
		if($this->config->read('theme/ie/scripts')){
			$html  = '<!--[if lt IE 9]>';

			foreach($this->config->read('theme/ie/scripts') as $file){
				$html .= '<script src="'. $file . '" type="text/javascript"></script>';
			}

			$html .= '<![endif]-->';

			return $html;
		}
		return '';
	}
	// Load Script Files
	public function load_files(){
		// Load JS Files
		if($this->config->read('theme/scripts')){
			foreach($this->config->read('theme/scripts') as $name => $url){
				wp_enqueue_script($name, $url);
			}
		}
		// Load CSS Files
		if($this->config->read('theme/styles')){
			foreach($this->config->read('theme/styles') as $name => $url){
				wp_enqueue_style($name, $url);
			}
		}
	}
	private function enqueue_files(){
		add_action('wp_enqueue_scripts', array($this, 'load_files'));
	}
	// If modified since
	private function if_modified_since(){
		$post_id = get_the_ID();

		if($post_id){
			$last_modified = new DateTime(get_the_modified_time("D, d M Y H:i:s", $post_id));
			$expires = clone $last_modified;
			$expires->add(new DateInterval("P30D"));

			header("Last-Modified: " . $last_modified->format("D, d M Y H:i:s") . " GMT");
			header("Expires: " . $expires->format("D, d M Y H:i:s") . " GMT");
		}
	}
	// Remove type="" attributes
	public function remove_type_attr($tag, $handle = '') {
		return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
	}
	private function filter_type_attr(){
		add_filter('style_loader_tag', array($this, 'remove_type_attr'), 10, 2);
		add_filter('script_loader_tag', array($this, 'remove_type_attr'), 10, 2);
		add_filter('autoptimize_html_after_minify', array($this, 'remove_type_attr'), 10, 2);
	}
	// Load Mobile Navigation
	public function mobile_status_bar(){
		$html  = '<meta name="theme-color" content="'. $this->config->read('theme/colour') .'">';
		$html .= '<meta name="msapplication-navbutton-color" content="'. $this->config->read('theme/colour') .'">';
		$html .= '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';

		return $html;
	}
	public function extra_class_body(){
		// Top Gradient
		$pages_id = array(7, 336, 340, 338);

		if(in_array(get_the_ID(), $pages_id) || is_home() || is_category() || (is_single() && in_category(3))){
			return 'top-blue-gradient';
		}
	}
}
