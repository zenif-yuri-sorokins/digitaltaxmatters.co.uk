<?php
	class Navmenu extends Walker_Nav_Menu{
		private $config;

		function __construct($config){
			$this->config = $config;
		}
        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
        	global $wp_query;

        	$class_names = '';

	        $classes   = (empty($item->classes)) ? array() : (array) $item->classes;
	        $classes[] = 'menu-item-' . $item->ID;

	        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
	        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

	        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
	        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

	        $output .= '<li' . $id . $class_names .'>';

	        $title_alt_attr = (apply_filters('the_title', $item->title, $item->ID) != 'Home') ? apply_filters('the_title', $item->title, $item->ID) : $this->config->read('company/name'); 

	        $attributes  = (!empty($item->attr_title)) ? ' title="'. esc_attr($item->attr_title) .'"' : ' title="'. $title_alt_attr .'"';
	        $attributes .= (!empty($item->target)) ? ' target="'. esc_attr($item->target) .'"' : '';
	        $attributes .= (!empty($item->xfn)) ? ' rel="'. esc_attr($item->xfn) .'"' : '';
	        $attributes .= (!empty($item->url)) ? ' href="'. esc_attr($item->url) .'"' : '';

	        $item_output  = $args->before;
	        $item_output .= '<a'. $attributes .'>';
	        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
	        $item_output .= '</a>';

	        if('primary' == $args->theme_location){
	            $submenus = (0 == $depth || 1 == $depth) ? get_posts(array('post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array('key' => '_menu_item_menu_item_parent', 'value' => $item->ID, 'fields' => 'ids' )))) : false;
	            
	            $item_output .= (!empty($submenus)) ? (0 == $depth ? '<span class="arrow"><i class="fal fa-angle-down"></i></span>' : '<span class="arrow"><i class="fal fa-angle-down"></i></span>') : '';
	        }
        
        	$item_output .= $args->after;

        	$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
	}