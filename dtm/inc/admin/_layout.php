<?php
/**
* Class: _Layout
* Version: 2.0
* Description: Adds layout meta boxes to post and pages
* Last Changed: 08-08-2018
*/
class _Layout extends App{
	/**
	* Constutor
	* Loads page layout meta box to posts and pages
	*/
	public function _construct(){
		add_action('load-post.php', array($this, 'init_meta_box'));
		add_action('load-post-new.php', array($this, 'init_meta_box'));
	}
	/**
	* Initilises the meta boxes 
	*/
	public function init_meta_box(){
		add_action('add_meta_boxes', array($this, 'layout_meta_box'));
		add_action('save_post', array($this, 'page_layout_save'), 10, 2);
	}
	public function layout_meta_box(){
		$post_types = array('post', 'page');

		foreach($post_types as $post_type){
			add_meta_box(
				'page-layout-meta',
				'Page Layout',
				array($this, 'page_layout'),
				$post_type,
				'side',
				'low'
			);
		}
	}
	public function page_layout(){
		global $post;

		$values = get_post_custom($post->ID);

		// Page Layouts - Container
		$page_layout_type = isset($values['page_layout_type']) ? $values['page_layout_type'][0] : "";

		$html  = '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="page_layout_type" class="components-base-control__label">Page Layout Type</label>';
		$html .= '<select name="page_layout_type" id="page_layout_type" class="components-select-control__input">';

		foreach($this->config->read('theme/container_options') as $container_value => $container_name){
			$html .= '<option value="' . $container_value . '"' . (($page_layout_type == $container_value) ? ' selected="selected"' : '') . '>';
			$html .= $container_name;
			$html .= '</option>';
		}

		$html .= '</select>';
		$html .= '</div>';


		// Page Layouts - Sidebar
		$sidebar_type = isset($values['sidebar_type']) ? $values['sidebar_type'][0] : "";

		$html .= '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="sidebar_type" class="components-base-control__label">Sidebar Option</label>';
		$html .= '<select name="sidebar_type" id="sidebar_type" class="components-select-control__input">';

		foreach($this->config->read('theme/sidebar_options') as $sidebar_value => $sidebar_name){
			$html .= '<option value="' . $sidebar_value . '"' . (($sidebar_type == $sidebar_value) ? ' selected="selected"' : '') . '>';
			$html .= $sidebar_name;
			$html .= '</option>';
		}

		$html .= '</select>';
		$html .= '</div>';

		echo $html;

		wp_nonce_field('page_layout_nonce', 'page_layout_nonce');
	}
	public function page_layout_save($post_id){
		// Bail if we're doing an auto save
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		// if our nonce isn't there, or we can't verify it, bail
		if(!isset($_POST['page_layout_nonce']) || !wp_verify_nonce($_POST['page_layout_nonce'], 'page_layout_nonce')) return;

		// if our current user can't edit this post, bail
		if(!current_user_can('edit_post')) return;

		// Choice of page layout
		if(isset($_POST['page_layout_type'])) update_post_meta($post_id, 'page_layout_type', wp_kses( $_POST['page_layout_type'], array()));

		// Types of sidebars
		if(isset($_POST['sidebar_type'])) update_post_meta($post_id, 'sidebar_type', wp_kses($_POST['sidebar_type'], array()));
	}
}
