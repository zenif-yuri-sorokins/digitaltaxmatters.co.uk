<?php
/**
* Class: _Titlebar
* Version: 2.0
* Description: Adds title bar meta boxes to post and pages
* Last Changed: 08-08-2018
*/
class _Titlebar extends App{
	/**
	* Constutor
	* Loads page layout meta box to posts and pages
	*/
	public function _construct(){
		add_action('load-post.php', array($this, 'init_meta_box'));
		add_action('load-post-new.php', array($this, 'init_meta_box'));
	}
	/**
	* Adds titlebar meta box action to theme
	* Saves setting to page for meta box
	*/
	public function init_meta_box(){
		add_action('add_meta_boxes', array($this, 'titlebar_meta_box'));
		add_action('save_post', array($this, 'page_titlebar_save'), 10, 2);
	}
	/**
	* Initiaze Meta Boxes
	* Loads title bar box to posts and pages
	*/
	public function titlebar_meta_box(){
		$post_types = array('post', 'page');

		foreach($post_types as $post_type){
			add_meta_box(
				'page-titlebar-meta',
				'Page Title Bar',
				array($this, 'page_titlebar'),
				$post_type,
				'side',
				'low'
			);
		}
	}
	public function page_titlebar(){ 
		global $post;

		$values = get_post_custom($post->ID);

		// Background / Type
	    $title_bar_type = isset($values['cs_title_bar_type']) ? $values['cs_title_bar_type'][0] : "";

		$html  = '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_title_bar_type" class="components-base-control__label">Background / Type</label>';
		$html .= '<select name="cs_title_bar_type" id="cs_title_bar_type">';
		
		foreach($this->config->read('theme/title_bar_options/background') as $bg_value => $bg_name){
			$html .= '<option value="' . $bg_value . '"' . (($title_bar_type == $bg_value) ? ' selected="selected"' : '') . '>';
			$html .= $bg_name;
			$html .= '</option>';
		}

		$html .= '</select>';
		$html .= '</div>';

		// Container Width
	    $title_bar_width = isset($values['cs_title_bar_width']) ? $values['cs_title_bar_width'][0] : "";

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_title_bar_width" class="components-base-control__label">Container Width</label>';
		$html .= '<select name="cs_title_bar_width" id="cs_title_bar_width">';

		foreach($this->config->read('theme/title_bar_options/container') as $container_value => $container_name){
			$html .= '<option value="' . $container_value . '"' . (($title_bar_width == $container_value) ? ' selected="selected"' : '') . '>';
			$html .= $container_name;
			$html .= '</option>';
		}

		$html .= '</select>';
		$html .= '</div>';

		// Breadcrumb
	    $breadcrumb = isset($values['cs_page_header_breadcrumb']) ? $values['cs_page_header_breadcrumb'][0]  : "";

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_page_header_breadcrumb" class="components-base-control__label">Breadcrumb</label>';
		$html .= '<input type="checkbox" name="cs_page_header_breadcrumb" id="cs_page_header_breadcrumb"';
		$html .= ($breadcrumb == 'on') ? ' checked="checked"' : ''; 
		$html .= ' />';
		$html .= '</div>';

		// Heading
	    $page_heading = isset($values['cs_page_heading']) ? esc_attr($values['cs_page_heading'][0]) : "";

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_page_heading" class="components-base-control__label">Heading</label>';
		$html .= '<input type="text" placeholder="Please type heading" name="cs_page_heading" id="cs_page_heading" ';
		$html .= 'value="'. $page_heading .'" />';
		$html .= '</div>';

		// Subheading
	    $page_subheading = isset($values['cs_page_subheading']) ? esc_attr($values['cs_page_subheading'][0]) : "";

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_page_subheading" class="components-base-control__label">Subheading</label>';
		$html .= '<textarea name="cs_page_subheading" id="cs_page_subheading" height="150px">'. $page_subheading .'</textarea>';
		$html .= '</div>';

		// Background Overlay X
		$background_overlay_x = (isset($values['cs_background_overlay_x'])) ? esc_attr($values['cs_background_overlay_x'][0]) : '';

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_background_overlay_x" class="components-base-control__label">Background Overlay (x)</label>';
		$html .= '<input type="text" name="cs_background_overlay_x" id="cs_background_overlay_x" placeholder="0, 0, 0, 0.5" value="'. $background_overlay_x .'" />';
		$html .= '</div>';

		// Background Overlay Y
		$background_overlay_y = (isset($values['cs_background_overlay_y'])) ? esc_attr($values['cs_background_overlay_y'][0]) : '';

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_background_overlay_y" class="components-base-control__label">Background Overlay (y)</label>';
		$html .= '<input type="text" name="cs_background_overlay_y" id="cs_background_overlay_y" placeholder="0, 0, 0, 0.5" value="'. $background_overlay_y .'" />';
		$html .= '</div>';

		// Background Position
		$background_position = (isset($values['cs_background_position'])) ? esc_attr($values['cs_background_position'][0]) : '';

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="cs_background_position" class="components-base-control__label">Background Position</label>';
		$html .= '<input type="text" name="cs_background_position" id="cs_background_position" placeholder="50% 50%" value="'. $background_position .'" />';
		$html .= '</div>';

		echo $html;

		wp_nonce_field('cs_page_header_bg_nonce', 'cs_page_header_bg_nonce');
	}
	public function page_titlebar_save($post_id){
	    // Bail if we're doing an auto save
	    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	    // if our nonce isn't there, or we can't verify it, bail
	    if(!isset($_POST['cs_page_header_bg_nonce']) || !wp_verify_nonce($_POST['cs_page_header_bg_nonce'], 'cs_page_header_bg_nonce')) return;

	    // if our current user can't edit this post, bail
	    if(!current_user_can('edit_post')) return;

	    // Background / Type
	    if(isset($_POST['cs_title_bar_type'])) update_post_meta($post_id, 'cs_title_bar_type', wp_kses($_POST['cs_title_bar_type'], array()));

	    // Container Width
	    if(isset($_POST['cs_title_bar_width'])) update_post_meta($post_id, 'cs_title_bar_width', wp_kses($_POST['cs_title_bar_width'], array()));

	    // Heading
	    if(isset($_POST['cs_page_heading'])) update_post_meta($post_id, 'cs_page_heading', wp_kses($_POST['cs_page_heading'], array()));

	    // Subheading
	    if(isset($_POST['cs_page_subheading'])) update_post_meta($post_id, 'cs_page_subheading', wp_kses($_POST['cs_page_subheading'], array()));

	    // Breadcrumb
	    if(isset($_POST['cs_page_header_breadcrumb'])){
	        update_post_meta($post_id, 'cs_page_header_breadcrumb', wp_kses($_POST['cs_page_header_breadcrumb'], array()));
	    }
	    else{
	        update_post_meta($post_id, 'cs_page_header_breadcrumb', 'no');
	    }

	    // Background Overlay X
	    if(isset($_POST['cs_background_overlay_x'])) update_post_meta($post_id, 'cs_background_overlay_x', wp_kses($_POST['cs_background_overlay_x'], array()));

	    // Background Overlay Y
	    if(isset($_POST['cs_background_overlay_y'])) update_post_meta($post_id, 'cs_background_overlay_y', wp_kses($_POST['cs_background_overlay_y'], array()));

	    // Background Position
	    if(isset($_POST['cs_background_position'])) update_post_meta($post_id, 'cs_background_position', wp_kses($_POST['cs_background_position'], array()));
	}
}