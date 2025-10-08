<?php
	class Posts extends App{
		function _construct(){
			add_filter('pre_get_posts', array($this, 'exclude_categories'));
		}
    public function get_post_id(){
      if(in_the_loop()){
        $post_id = get_the_ID();
      } 
      else{
        global $wp_query;

        $post_id = $wp_query->get_queried_object_id();
      }
      return $post_id;
    }
 		public function exclude_categories($query){
 			if(count($this->config->read('post/exclude_categories')) > 0 && !empty($this->config->read('post/exclude_categories'))){
 				$category_ids = $this->config->read('post/exclude_categories');
 				$exc_cat_ids = '';
 				$i = 0;

 				foreach($category_ids as $id){
 					$exc_cat_ids .= '-' . $id;

 					if($i < (count($category_ids) - 1)){
 						$exc_cat_ids .= ',';
 					}

 					$i++;
 				}
 				if($query->is_home){
 					$query->set('cat', $exc_cat_ids);
 				}

  			return $query;
 			}

      return '';
  	}
    public function share(){
      $html  = '<div class="share-post">';
      $html .= '<div class="gi-row">';
      $html .= '<div class="gi-col-lg-5 gi-col-md-6 gi-col-sm-6">';
      $html .= '<h3 class="heading">Share this Article</h3>';
      $html .= '</div>';
      $html .= '<div class="gi-col-lg-7 gi-col-md-6 gi-col-sm-6 t-a-r">';
      $html .= $this->share_links();
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';

      return $html;
    }
    public function share_links($class = ''){
      $post_url = get_permalink();
      $post_title_url = str_replace(" ","%20", get_the_title());

      $class = (!empty($class)) ? ' class="inline '. $class .'"' : ' class="inline"';

      $facebook = "https://www.facebook.com/sharer/sharer.php?u=" . $post_url;
      $twitter = "https://twitter.com/home?status=Check%20out%20this%20article:%20". $post_title_url ."-%20". $post_url;
      $google = "https://plus.google.com/share?url=" . $post_url;
      $linkedin = "https://www.linkedin.com/shareArticle?mini=true&url=". $post_url ."&source=Gud%20Ideas";
      
      $html  = '<ul'. $class .'>';
      $html .= '<li><a href="'. $facebook .'" title="Share On Facebook" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a></li>';
      $html .= '<li><a href="'. $twitter .'" title="Share On Twitter" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a></li>';
      $html .= '<li><a href="'. $google .'" title="Share On Google+" target="_blank" class="google"><i class="fab fa-google"></i></a></li>';
      $html .= '<li><a href="'. $linkedin .'" title="Share On LinkedIn" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>';
      $html .= '</ul>';

      return $html;
    }
    public function related_posts(){
      $post_category = get_the_category();
      $post_category = $post_category[0];
      $post_category_id = $post_category->term_id;

      $related_posts = get_posts(array(
          'numberposts' => 4,
          'categroy' => $post_category_id,
          'exclude' => get_the_ID()
      ));

      $countNum = 1;

      $html = '';

      if(count($related_posts) > 0){
          $html .= '<div class="more-articles">';
          $html .= '<h3 class="heading">You Can Also Read...</h3>';
          $html .= '<div class="gi-row">';

          foreach($related_posts as $related_post){
              $thumb_id = get_post_thumbnail_id($related_post->ID);
              $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
              $thumb_url = $thumb_url_array[0];
              $html .= '<div class="gi-col-lg-6 gi-col-md-6 gi-col-sm-12">';
              $html .= '<div class="article">';
              $html .= '<h4 class="article-heading"><a href="'. esc_url(get_permalink($related_post->ID)) .'" title="'. get_the_title($related_post->ID) .'">'. get_the_title($related_post->ID) .'</a></h4>';
              $html .= '<span class="date">'. get_the_date('dS M Y', $related_post->ID) .'</span>';
              $html .= '<p class="content">'. trim(substr(strip_tags($related_post->post_content), 0, 70)) .'...</p>';
              $html .= '</div>';
              $html .= '</div>';

              $countNum++;
          }
          $html .= '</div>';
          $html .= '</div>';
      }

      return $html;
    }
    public function prev_next_post(){
      $prev_post = get_previous_post(false, $this->config->read('post/exclude_categories'));
      $next_post = get_next_post(false, $this->config->read('post/exclude_categories'));

      if(!empty($prev_post) || !empty($next_post)){
        $html  = '<div class="prev-next-post">';
        $html .= '<div class="gi-row">';
        
        if(!empty($prev_post)){
          $html .= '<div class="gi-col-sm-6">';
          $html .= '<a href="'. get_permalink($prev_post->ID) .'" title="Previous Post: '. get_the_title($prev_post->ID) .'" class="prev-next-post-button prev-post">';
          $html .= '<span class="title">'. get_the_title($prev_post->ID) .'</span>';
          $html .= '<span class="link"><i class="fal fa-angle-double-left"></i> Previous Post</span>';
          $html .= '</a>';
          $html .= '</div>';
        }

        if(!empty($next_post)){
          $html .= '<div class="gi-col-sm-6 float-right t-a-r">';
          $html .= '<a href="'. get_permalink($next_post->ID) .'" title="Next Post: '. get_the_title($next_post->ID) .'" class="prev-next-post-button next-post">';
          $html .= '<span class="title">'. get_the_title($next_post->ID) .'</span>';
          $html .= '<span class="link">Next Post <i class="fal fa-angle-double-right"></i></span>';
          $html .= '</a>';
          $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
      }
    }
    public function get_featured_image($id = false, $size = 'medium_large'){
      $thumb_id = get_post_thumbnail_id($id);
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, $size, true);
      $thumb_url = $thumb_url_array[0];

      return $thumb_url;
    }
    public function hentry(){
      if($this->config->read('vendors/schema')){
        $published_date = get_the_date('Y-m-d') . 'T' . get_the_date('H:i:s');
        $modified_date = get_the_modified_date('Y-m-d') . 'T' . get_the_modified_date('H:i:s');
        $post_published = get_the_date('d') . '<sup>'. get_the_date('S') .'</sup> ' . get_the_date('F Y');
        $post_updated = get_the_modified_date('d') . '<sup>'. get_the_modified_date('S') .'</sup> ' . get_the_modified_date('F Y');
        $title = (get_the_title() != 'Home') ? get_the_title() : $this->config->read('company/name') . '\'s Home Page';

        $html  = '<div class="post-info hidden">';
        $html .= 'Published by ';
        $html .= '<span class="author_name vcard">';
        $html .= '<span class="fn">'. get_the_author() .'</span>';
        $html .= '</span>';
        $html .= ' on <time class="published" datetime="'. str_replace('T', ' ', $published_date) .'">';
        $html .= $post_published;
        $html .= '</time>, ';
        $html .= '<span class="entry-title">'. $title .'</span>';
        $html .= ', Updated on <time class="updated" datetime="' . str_replace('T', ' ', $modified_date) .'">';
        $html .= $post_updated;
        $html .= '</time>';
        $html .= '</div>';

        return $html;
      }

      return '';
    }
    public function get_post_type(){
      $cs_values = get_post_custom($this->get_post_id());
      $page_type = (isset($cs_values['page_type'])) ?  $cs_values['page_type'][0]  : "";

      return $page_type;
    }
	}