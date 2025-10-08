<?php
class Titlebar extends App{
	private $default_section_class;
	private $default_container_class;
	private $posts;
	private $post_id;

	function _construct(){
		$layout = new Layout();
		$this->default_section_class = $layout->get_sc_layout($this->config->read('theme/layout'))['section'];
		$this->default_container_class = $layout->get_sc_layout($this->config->read('theme/layout'))['container'];

		$this->posts = new Posts();
		$this->post_id = $this->posts->get_post_id();
	}
	public function get_title_bar(){
		$cs_values = get_post_custom($this->post_id);

		// Type
		$title_bar_type = (isset($cs_values['cs_title_bar_type'])) ?  $cs_values['cs_title_bar_type'][0]  : "";

		if($title_bar_type != 'bg-hidden' && $title_bar_type != ''){
			$title_bar_classes = (!empty($this->default_section_class)) ? $this->default_section_class : '';
			$title_bar_bg = '';
			$bg_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

			if($title_bar_type == 'bg-image' || (is_single() && !empty($bg_url))){
				$bg_overlay_x = (!empty($cs_values['cs_background_overlay_x'][0])) ?  $cs_values['cs_background_overlay_x'][0] : $this->config->read('theme/title_bar_options/bg_overlay/x');
				$bg_overlay_y = (!empty($cs_values['cs_background_overlay_y'][0])) ?  $cs_values['cs_background_overlay_y'][0] : $this->config->read('theme/title_bar_options/bg_overlay/y');
				$bg_position = (!empty($cs_values['cs_background_position'][0])) ?  $cs_values['cs_background_position'][0] : $this->config->read('theme/title_bar_options/bg_position');

				$title_bar_classes .= ' title-bar-img';
				$title_bar_bg = ' style="background: linear-gradient(rgba('. $bg_overlay_x .'), rgba('. $bg_overlay_y .')), url('. $bg_url .') '. $bg_position .' / cover;"';
			}
			else{
				$title_bar_classes .= ' ' . $title_bar_type;
			}

			// Container
			$container = (!empty($cs_values['cs_title_bar_width'][0])) ? $cs_values['cs_title_bar_width'][0] : $this->default_container_class;

			// Heading
			$heading_schema = '';
			$subheading_schema = '';

			if($this->config->read('vendors/schema')){
				$page_type = (isset($cs_values['page_type'])) ?  $cs_values['page_type'][0] : "";

				// Article & News Article
				if($page_type == 'article' || $page_type == 'news-article'){
					$heading_schema .= ' itemprop="headline"';
				}
				// How To Guide
				if($page_type == 'how-to-guide'){
					$heading_schema .= ' itemprop="headline"';
				}
				// QA Page
				if($page_type == 'qa'){
					$heading_schema .= ' itemprop="name"';
					$subheading_schema .= ' itemprop="text"';
				}
			}

			$heading = (!empty($cs_values['cs_page_heading'][0])) ? $cs_values['cs_page_heading'][0] : single_post_title('', false);
			$heading = (!empty($heading)) ? '<div class="gi-row"><div class="gi-col-sm-12"><h1 class="title-bar-heading"'. $heading_schema .'>'. $heading .'</h1></div></div>' : '';

			// Subheading
			$subheading = (!empty($cs_values['cs_page_subheading'][0])) ? $cs_values['cs_page_subheading'][0] : '';
			$subheading = (!empty($subheading)) ? '<div class="gi-row"><div class="gi-col-sm-12"><p class="title-bar-subheading"'. $subheading_schema .'>'. $subheading .'</p></div></div>' : '';

			// Breadcrumb
			$breadcrumb = ($cs_values['cs_page_header_breadcrumb'][0] == 'on') ? $this->breadcrumb() : '';
			$breadcrumb = (!empty($breadcrumb)) ? '<div class="gi-row"><div class="gi-col-sm-12">'.  $this->breadcrumb() .'</div></div>' : '';

			// Title Bar
			$html  = '<section id="title-bar" class="'. trim($title_bar_classes) .'"'. $title_bar_bg .'>';
			$html .= '<div class="'. $container .'">';

			if(is_single() && !in_category($this->config->read('post/exclude_categories'))){
				$html .= $this->posts->share_links('social');
				$html .= $this->post_author_date();
			}

			$html .= $heading;
			$html .= $subheading;
			$html .= $breadcrumb;
			$html .= '</div>';
			$html .= '</section>';

			return $html;
		}
	}
	public function breadcrumb(){
		if(!is_front_page()){
			global $post;

			$allow_schema = $this->config->read('vendors/schema');
			$url = $this->config->read('base_url');
			$counter = 1;

			$html  = '<ul class="breadcrumb"'. (($allow_schema == true) ? ' itemscope itemtype="http://schema.org/BreadcrumbList"' : '') .'>';
			$html .= '<li'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
			$html .= '<a href="'. get_home_url() .'" title="'. $this->config->read('company/name') .'"'. (($allow_schema == true) ? ' itemtype="http://schema.org/Thing" itemprop="item"' : '') .'>';
			$html .= ($allow_schema == true) ? '<span itemprop="name">Home</span>' : 'Home';
			$html .= '</a>';
			$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';
			$html .= '</li>';

			$counter++;

			// Page
			if(is_page()){
				if($post->post_parent){
					$anc = get_post_ancestors($this->post_id);
					$anc = array_reverse($anc);

					foreach($anc as $ancestor){
						$html .= '<li'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
						$html .= '<a href="'. get_permalink($ancestor) .'" title="'. get_the_title($ancestor) .'"'. (($allow_schema == true) ? ' itemtype="http://schema.org/Thing" itemprop="item"' : '') .'>';
						$html .= ($allow_schema == true) ? '<span itemprop="name">'. get_the_title($ancestor) .'</span>' : get_the_title($ancestor);
						$html .= '</a>';
						$html .= '<meta itemprop="position" content="'. $counter .'" />';
						$html .= '</li>';

						$counter++;
					}
				}

				$html .= '<li class="active"'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
				$html .= ($allow_schema == true) ? '<meta itemtype="http://schema.org/Thing" itemprop="item" content="'. get_permalink() .'" />' : '';
				$html .= ($allow_schema == true) ? '<span itemprop="name">'. get_the_title() .'</span>' : get_the_title();
				$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';
				$html .= '</li>';
			}
			// Single Blog Posts
			if(is_single()){
				$exclude_cats = $this->config->read('post/exclude_categories');

				if(in_category($exclude_cats)){
					foreach($exclude_cats as $cat){
						if(in_category($cat)){
							$cat = get_category($cat);

							$html .= '<li'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
							$html .= '<a href="'. get_category_link($cat->cat_ID) .'" title="'. $cat->name .'"'. (($allow_schema == true) ? ' itemtype="http://schema.org/Thing" itemprop="item"' : '') .'>';
							$html .= ($allow_schema == true) ? '<span itemprop="name">'. $cat->name .'</span>' : $cat->name;
							$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';
							$html .= '</a>';
							$html .= '</li>';

							break;
						}
					}
				}
				else{
					$html .= '<li'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
					$html .= '<a href="'. get_permalink(get_option('page_for_posts')) .'" title="'. get_the_title(get_option('page_for_posts')) .'"'. (($allow_schema == true) ? ' itemtype="http://schema.org/Thing" itemprop="item"' : '') .'>';
					$html .= ($allow_schema == true) ? '<span itemprop="name">'. get_the_title(get_option('page_for_posts')) .'</span>' : get_the_title(get_option('page_for_posts'));
					$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';
					$html .= '</a>';
					$html .= '</li>';
				}

				$counter++;

				$html .= '<li class="active"'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
				$html .= ($allow_schema == true) ? '<meta itemtype="http://schema.org/Thing" itemprop="item" content="'. get_permalink() .'" />' : '';
				$html .= ($allow_schema == true) ? '<span itemprop="name">'. get_the_title() .'</span>' : get_the_title();
				$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';
				$html .= '</li>';
			}
			// Blog Page
			if(is_home()){
				$html .= '<li class="active"'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
				$html .= ($allow_schema == true) ? '<meta itemtype="http://schema.org/Thing" itemprop="item" content="'. get_permalink(get_option('page_for_posts')) .'" />' : '';
				$html .= ($allow_schema == true) ? '<span itemprop="name">'. get_the_title(get_option('page_for_posts')) .'</span>' : get_the_title(get_option('page_for_posts'));
				$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';				
				$html .= '</li>';
			}
			// Category Page 
			if(is_category()){
				$html .= '<li class="active"'. (($allow_schema == true) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' : '') .'>';
				$html .= ($allow_schema == true) ? '<meta itemtype="http://schema.org/Thing" itemprop="item" content="'. get_category_link(get_cat_ID(single_cat_title('', false))) .'" />' : '';
				$html .= ($allow_schema == true) ? '<span itemprop="name">'. single_cat_title('', false) .'</span>' : single_cat_title();
				$html .= ($allow_schema == true) ? '<meta itemprop="position" content="'. $counter .'" />' : '';				
				$html .= '</li>';
			}

			$html .= '</ul>';

			return $html;
		}
	}
	private function post_author_date(){
		$allow_schema = $this->config->read('vendors/schema');
        $published_date = get_the_date('Y-m-d') . 'T' . get_the_date('H:i:s');
        $modified_date = get_the_modified_date('Y-m-d') . 'T' . get_the_modified_date('H:i:s');

		$html  = '<div class="gi-row">';
		$html .= '<div class="gi-col-sm-12">';
		$html .= '<ul class="post-details inline">';
		$html .= '<li'. (($allow_schema) ? ' itemprop="author" itemscope itemtype="http://schema.org/Person"' : '') .'>';
		$html .= '<span class="f-w-bold">Author:</span> ';
		$html .= ($allow_schema) ? '<span itemprop="name">'. get_the_author() .'</span>' : get_the_author(); 
		$html .= '</li>';
		$html .= '<li>';
		$html .= '<span class="f-w-bold">Date:</span> ';
		$html .= get_the_date();
		$html .= ($allow_schema) ? '<span class="hidden" itemprop="datePublished">'. $modified_date .'</span>' : '';
		$html .= ($allow_schema) ? '<span class="hidden" itemprop="dateModified">'. $published_date .'</span>' : '';
		$html .= '</li>';
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}