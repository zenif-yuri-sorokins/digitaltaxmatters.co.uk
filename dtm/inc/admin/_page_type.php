<?php
/**
* Class: _Page_Type
* Version: 2.0
* Description: Adds layout meta boxes to post and pages
* Last Changed: 08-08-2018
*/
class _Page_Type extends App{
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
		add_action('add_meta_boxes', array($this, 'page_type_meta_box'));
		add_action('save_post', array($this, 'page_type_save'), 10, 2);
	}
	public function page_type_meta_box(){
		$post_types = array('post', 'page');

		foreach($post_types as $post_type){
			add_meta_box(
				'page-type-meta',
				'Page Type',
				array($this, 'page_type'),
				$post_type,
				'side',
				'low'
			);
		}
	}
	public function page_type(){
		global $post;

		$values = get_post_custom($post->ID);

		// Page Type
		$page_type = isset($values['page_type']) ? $values['page_type'][0] : "";

		$html  = '<div class="components-base-control editor-page-attributes__template">';
		$html .= '<label for="page_type" class="components-base-control__label">Page/Post Type</label>';
		$html .= '<select name="page_type" id="page_type" class="components-select-control__input">';

		$page_type_arr = $this->config->read('theme/page_types');

		if($post->post_type != 'post'){
			$page_type_arr = array_merge(array(
				'normal-page' => 'Normal Page'
			), $page_type_arr);
		}
		else{
			$page_type_arr = array_merge(array(
				'article' => 'Article',
				'news-article' => 'New Article'
			), $page_type_arr);
		}

		foreach($page_type_arr as $page_type_value => $page_type_name){
			$html .= '<option value="' . $page_type_value . '"' . (($page_type == $page_type_value) ? ' selected="selected"' : '') . '>';
			$html .= $page_type_name;
			$html .= '</option>';
		}

		$html .= '</select>';
		$html .= '</div>';

		echo $html;

		wp_nonce_field('page_type_nonce', 'page_type_nonce');
	}
	public function page_type_save($post_id){
		// Bail if we're doing an auto save
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		// if our nonce isn't there, or we can't verify it, bail
		if(!isset($_POST['page_type_nonce']) || !wp_verify_nonce($_POST['page_type_nonce'], 'page_type_nonce')) return;

		// if our current user can't edit this post, bail
		if(!current_user_can('edit_post')) return;

		// Choice of page layout
		if(isset($_POST['page_type'])) update_post_meta($post_id, 'page_type', wp_kses( $_POST['page_type'], array()));
	}
}
