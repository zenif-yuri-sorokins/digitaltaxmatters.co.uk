<?php
class Layout extends App{
	private $post_id;

	function _construct(){
		$_posts = new Posts();
		$this->post_id = $_posts->get_post_id();
	}
	public function get_layout(){
		$cs_values = get_post_custom($this->post_id);
		$response = array();

		$sidebar_type = (isset($cs_values['sidebar_type']))? $cs_values['sidebar_type'][0] : 'no-sidebar';

		// Return Container Settings
		$response['width'] = (isset($cs_values['page_layout_type']))? $cs_values['page_layout_type'][0] : 'gi-container';

		// Return Sidebar Settings
		if($sidebar_type != 'no-sidebar'){
			$response['primary_col'] = 'gi-col-sm-' . (12 - $this->config->read('theme/sidebar_col_size'));
			$response['sidebar_col'] = 'gi-col-sm-' . $this->config->read('theme/sidebar_col_size');

			if($sidebar_type == 'sidebar-left'){
				$response['sidebar_left_show'] = true;
				$response['sidebar_right_show'] = false;
			}
			if($sidebar_type == 'sidebar-right'){
				$response['sidebar_left_show'] = false;
				$response['sidebar_right_show'] = true;
			}
		}
		else{
			$response['primary_col'] = 'gi-col-sm-12';
			$response['sidebar_left_show'] = false;
			$response['sidebar_right_show'] = false;
		}

		return $response;
	}
	public function get_sc_layout($config = ''){
		$config = (empty($config)) ? $this->config->read('theme/layout') : $config;

		$layout = array();

		if($config != 'contained'){
			$layout['section'] = 'sec-full-width';
			$layout['container'] = 'gi-container-fluid';
		}
		else{
			$layout['section'] = 'sec-contained';
			$layout['container'] = 'gi-container';
		}

		return $layout;
	}
}
