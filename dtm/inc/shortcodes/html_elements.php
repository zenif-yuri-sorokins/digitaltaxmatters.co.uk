<?php
class HTML_Elements{
  private $config;
  private $post_id;

  function __construct($config){
    $this->config = $config;

    // Load Shortcodes
    add_shortcode('link', array($this, 'link'));
    add_shortcode('img', array($this, 'img'));
    add_shortcode('faq', array($this, 'faq'));
    add_shortcode('list', array($this, 'list'));
    add_shortcode('list-item', array($this, 'list_item'));
    add_shortcode('how-to-guide', array($this, 'how_to_guide'));
    add_shortcode('how-to-guide-tool', array($this, 'how_to_guide_tool'));
    add_shortcode('how-to-guide-name', array($this, 'how_to_guide_name'));
    add_shortcode('how-to-guide-supply', array($this, 'how_to_guide_supply'));
    add_shortcode('how-to-guide-step', array($this, 'how_to_guide_step'));
    add_shortcode('how-to-guide-step-inner', array($this, 'how_to_guide_step_inner'));
    add_shortcode('how-to-guide-step-direction', array($this, 'how_to_guide_step_direction'));
    add_shortcode('how-to-guide-step-tip', array($this, 'how_to_guide_step_tip'));
    add_shortcode('icon-box', array($this, 'icon_box'));
    add_shortcode('package-box', array($this, 'package_box'));
    add_shortcode('service-box', array($this, 'service_box'));
    add_shortcode('scroll-down', array($this, 'scroll_down'));
    add_shortcode('xero-partnership', array($this, 'xero_partnership'));
    add_shortcode('company-logos', array($this, 'company_logos'));
    add_shortcode('banner-clients-rating', array($this, 'banner_clients_rating'));
    add_shortcode('stat', array($this, 'stat'));
    add_shortcode('resource-loader', array($this, 'resource_loader'));
    add_shortcode('get-success-story-image', array($this, 'get_success_story_image'));
    add_shortcode('package-table', array($this, 'package_table'));
    add_shortcode('projects-feed', array($this, 'projects_feed'));
  }


  public function projects_feed($attr, $content = '')
  {
      // Extract attributes and set default values
      $attr = shortcode_atts([
          'posts_per_page' => 2, // Default number of posts
          'category' => 7, // Default category ID
          'col_size' => '3',
          'responsive_col' => 'col-sm-', // Default column class
      ], $attr);
  
      // Query arguments
      $query_args = [
          'post_type' => 'post',
          'posts_per_page' => intval($attr['posts_per_page']),
          'post_status' => 'publish',
          'cat' => intval($attr['category']), // Use 'cat' instead of 'category' for WP_Query
          'orderby' => 'date',
          'order' => 'DESC',
      ];
  
      $query = new WP_Query($query_args);
  
      // Start output buffering
      ob_start();
  
      if ($query->have_posts()) :
        
          while ($query->have_posts()) : $query->the_post();
  
              // Set the heading tag based on the post position
              $tag = ($query->current_post + 1 == $query->post_count) ? 'h2' : 'h3';
              $title = sprintf('<%1$s class="heading">%2$s</%1$s>', esc_html($tag), esc_html(get_the_title()));
  
              // Get the post thumbnail URL
              $thumbnail_id = get_post_thumbnail_id();
              $image_url = wp_get_attachment_image_src($thumbnail_id, 'large'); // Use 'large' or set a custom size
              $image_url = $image_url ? esc_url($image_url[0]) : '';
  
              ?>
              <article id="post-<?php the_ID(); ?>">
                  <div class="project-box">
                      <a href="<?php echo esc_url(get_permalink()); ?>" class="project-box-wrapper" title="<?php echo esc_attr(get_the_title()); ?>">
                          <div class="img-wrapper img-hover-wrapper">
                              <div class="img-area">
                                  <div class="img-area-inner" style="background: url(<?php echo $image_url; ?>) center center / cover;"></div>
                              </div>
                          </div>
                          <div class="content-area">
                              <div class="content-inner">
                                  <?php
                                  if (!in_category($attr['category'])) {
                                      echo '<span class="date">' . esc_html(get_the_date('jS M Y')) . '</span>';
                                  }
  
                                  // Display the title
                                  echo $title;
  
                                  // Get content based on category
                                  $content = '';
                                  if (in_category($attr['category'])) {
                                      $custom_fields = get_post_custom(get_the_ID());
                                      $content = isset($custom_fields['cs_page_subheading'][0]) ? $custom_fields['cs_page_subheading'][0] : '';
                                  } else {
                                      $content = strip_tags(get_the_content());
                                  }
  
                                  if (!empty($content)) :
                                      ?>
                                      <p class="content"><?php echo esc_html(substr(trim($content), 0, 100)) . '...'; ?></p>
                                  <?php endif; ?>
  
                                  <span class="btn btn-line btn-line-no-arrow">
                                      <?php echo in_category($attr['category']) ? 'Read More' : 'Read Article'; ?>
                                      <i class="far fa-long-arrow-right icon right"></i>
                                  </span>
                              </div>
                          </div>
                      </a>
                  </div>
              </article>
              <?php
          endwhile;
          wp_reset_postdata();
      else :
          echo '<p>No posts found.</p>';
      endif;
  
      // Get the buffered content
      $output = ob_get_clean();
  
      // Return the content for the shortcode
      return $output;
  }


  public function link($attr, $content = ''){
    $attr = shortcode_atts(array(
      'url'  => '',
      'type' => 'internal',
      'title' => '',
      'no_follow' => '',
      'class' => ''
    ), $attr);

    $html = '';

    if(!empty($content)){
      $url = (!empty($attr['url'])) ? ' href="'. $attr['url'] .'"' : '';
      $title = (!empty($attr['title'])) ? ' title="'. $attr['title'] .'"' : ' title="'. trim(strip_tags($content)) .'"';
      $class = (!empty($attr['class'])) ? ' class="'. $attr['class'] .'"' : '';

      $rel  = ($attr['type'] == 'external') ? 'noopener' : '';
      $rel .= ((empty($attr['no_follow']) || $attr['no_follow'] == 'yes') && $attr['type'] == 'external') ? ' nofollow' : '';

      $type = ($attr['type'] == 'external') ? ' target="_blank" rel="'. trim($rel) .'"' : '';

      $html .= '<a'. $url . $title . $class . $type .'>';
      $html .= do_shortcode($content);
      $html .= '</a>';
    }

    return $html;
  }
  public function img($attr){
    $attr = shortcode_atts(array(
      'src' => '',
      'alt' => '',
      'class' => '',
      'link' => '',
      'type' => 'internal',
      'no_follow' => '',
    ), $attr);

    $html = '';

    if(!empty($attr['src'])){
      $src = ' src="'. get_template_directory_uri() .'/images/placeholder-image.png" data-src="' . $attr['src'] . '"';
      $alt = (!empty($attr['alt'])) ? ' alt="' . $attr['alt'] . '"' : '';
      $class = (!empty($attr['class'])) ? ' class="'. $attr['class'] .' lazy"' : ' class="lazy"';

      if(!empty($attr['link'])){
        $link = (!empty($attr['link'])) ? ' href="'. $attr['link'] .'"' : '';
        $title = (!empty($attr['alt'])) ? ' title="' . $attr['alt'] . '"' : '';

        $rel  = ($attr['type'] == 'external') ? 'noopener' : '';
        $rel .= ((empty($attr['no_follow']) || $attr['no_follow'] == 'yes') && $attr['type'] == 'external') ? ' nofollow' : '';

        $type = ($attr['type'] == 'external') ? ' target="_blank" rel="'. trim($rel) .'"' : '';

        $html .= '<a'. $link . $title . $type .'>';
      }

      $html .= '<img'. $src . $alt . $class .' />';

      if(!empty($attr['link'])){
        $html .= '</a>';
      }
    }

    return $html;
  }
  public function faq($attr, $content = ''){
    $attr = shortcode_atts(array(
      'question' => '',
      'tag' => 'span',
      'type' => '',
      'link' => '',
      'class' => '',
      'answer_tag' => 'p'
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $html = '';

    if($attr['type'] != 'link'){
      $html .= '<div class="faq"'. (($allow_schema) ? ' itemprop="mainEntity" itemscope itemtype="http://schema.org/Question"' : '') .'>';
      $html .= '<'. $attr['tag'] .' class="question">';
      $html .= ($allow_schema) ? '<span itemprop="name">'. $attr['question'] . '</span>' : $attr['question'];
      $html .= '</'. $attr['tag'] .'>';
      $html .= '<div class="answer"'. (($allow_schema) ? ' itemprop="suggestedAnswer acceptedAnswer" itemscope itemtype="http://schema.org/Answer"' : '') .'>';
      $html .= ($allow_schema) ? '<div itemprop="author" itemscope itemtype="http://schema.org/Person">' : '';
      $html .= ($allow_schema) ? '<meta itemprop="name" content="'. $this->config->read('company/name') .'">' : '';
      $html .= ($allow_schema) ? '</div>' : '';
      $html .= ($allow_schema) ? '<a itemprop="url" href="'. get_permalink() .'" class="hidden">Answer Link</a>' : '';
      $html .= '<'. $attr['answer_tag'] .'>';
      $html .= '<span'. (($allow_schema) ? ' itemprop="text"' : '') .'>';
      $html .= strip_tags($content);
      $html .= '</span>';
      $html .= '</'. $attr['answer_tag'] .'>';
      $html .= '</div>';
      $html .= ($allow_schema) ? '<meta itemprop="text" value="'. $content .'">' : '';
      $html .= '</div>';
    }
    else{
      $link  = (!empty($attr['link'])) ? ' href="'. $attr['link'] .'"' : ' href="javascript:void(0);"';
      $class = (!empty($attr['class'])) ? 'faq faq-link ' . $attr['class'] : 'faq faq-link';

      $html .= '<div class="'. $class .'"'. (($allow_schema) ? ' itemprop="mainEntity" itemscope itemtype="http://schema.org/Question"' : '') .'>';
      $html .= '<a'. $link .' title="'. $attr['question'] .'" class="question-wrapper">';
      $html .= '<'. $attr['tag'] .' class="question">';
      $html .= ($allow_schema) ? '<span itemprop="name">'. $attr['question'] . '</span>' : $attr['question'];
      $html .= '</'. $attr['tag'] .'>';
      $html .= '</a>';
      $html .= '<div itemprop="suggestedAnswer acceptedAnswer" itemscope itemtype="http://schema.org/Answer" class="answer-wrapper" style="display: none;">';
      $html .= '<div class="answer" itemprop="text">';
      $html .= do_shortcode($content);
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';
    }
    return $html;
  }
  public function list($attr, $content = ''){
    $attr = shortcode_atts(array(
      'class' => '',
      'type' => 'normal'
    ), $attr);

    $class = (!empty($attr['class'])) ? ' class="'. $attr['class'] .'"' : '';
    $allow_schema = $this->config->read('vendors/schema');
    $tag = ($attr['type'] == 'ordered') ? 'ol' : 'ul';

    $html  = '<'. $tag . $class . (($allow_schema) ? ' itemscope itemtype="http://schema.org/ItemList"' : '') .'>';

    if($attr['type'] == 'ordered' && $allow_schema == true){
      $html .= '<link itemprop="itemListOrder" href="http://schema.org/ItemListOrderDescending" />';
    }

    $html .= do_shortcode($content);
    $html .= '</'. $tag .'>';

    return $html;
  }
  public function list_item($attr, $content = ''){
    $attr = shortcode_atts(array(
      'class' => '',
      'href' => '',
      'title' => ''
    ), $attr);

    $content = do_shortcode($content);

    $allow_schema = $this->config->read('vendors/schema');
    $link_title = (!empty($attr['title'])) ? $attr['title'] : strip_tags($content);
    $link_attr = ' href="'. $attr['href'] .'" title="'. $link_title .'"';

    $html  = '<li'. (($allow_schema) ? ' itemprop="itemListElement"' : '') .'>';
    $html .= (!empty($attr['href'])) ? '<a'. $link_attr . '>' : '';
    $html .= $content;
    $html .= (!empty($attr['href'])) ? '</a>' : '';
    $html .= '</li>';

    return $html;
  }
  public function how_to_guide($attr, $content = ''){
    $attr = shortcode_atts(array(
      'cost' => '',
      'duration_hours' => '',
      'duration_minutes' => ''
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $html = '<div class="how-to-guide">';
    $cost = '';
    $duration = '';

    if(!empty($attr['cost']) || !empty($attr['duration'])){
      $html .= '<div class="hidden">';
    }

    if(!empty($attr['cost']) && is_numeric($attr['cost'])){
      $cost  = '<div class="cost">';
      
      if($allow_schema){
        $cost .= '<span itemprop="estimatedCost" itemscope itemtype="http://schema.org/MonetaryAmount">';
        $cost .= '<meta itemprop="currency" content="'. $this->config->read('currency/code') .'"/>';
        $cost .= '<meta itemprop="value" content="'. $attr['cost'] .'"/>';
      }

      $cost .= $this->config->read('currency/sign') . $attr['cost'];
      $cost .= ($allow_schema) ? '</span>' : '';
      $cost .= '</div>';
    }

    if(!empty($attr['duration_hours']) || !empty($attr['duration_minutes'])){
      $time = 'PT';
      $time_hour = '';
      $time_min = '';
      $duration_time = '';

      if(!empty($attr['duration_hours']) && is_numeric($attr['duration_hours']) && $attr['duration_hours'] > 0){
        $time_hour = $attr['duration_hours'] . 'H';
        $extra_s = ($attr['duration_hours'] > 1) ? 's' : '';
        $duration_time .= $attr['duration_hours'] . ' Hour' . $extra_s;
      }
      if(!empty($attr['duration_minutes']) && is_numeric($attr['duration_minutes']) && $attr['duration_minutes'] > 0){
        $time_min = $attr['duration_minutes'] . 'M';
        $extra_s = ($attr['duration_minutes'] > 1) ? 's' : '';
        $duration_time .= ' ' . $attr['duration_minutes'] . ' Minute' . $extra_s;
      }

      $time .= $time_hour . $time_min;

      $duration  = '<div class="duration">';
      $duration .= ($allow_schema) ? '<span itemprop="totalTime" content="'. $time .'">' : '';
      $duration .= trim($duration_time);
      $duration .= ($allow_schema) ? '</span>' : '';
      $duration .= '</div>';
    }

    $html .= $cost;
    $html .= $duration;

    if(!empty($attr['cost']) || !empty($attr['duration'])){
      $html .= '</div>';
    }

    $html .= do_shortcode($content);

    $html .= '</div>';

    return $html;
  }
  public function how_to_guide_name($attr, $content = ''){
    $attr = shortcode_atts(array(
      'tag' => 'h2'
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $html  = '<'. $attr['tag'] .' class="how-to-guide-name"'. (($allow_schema) ? ' itemprop="name"' : '') .'>';
    $html .= do_shortcode($content);
    $html .= '</'. $attr['tag'] .'>';

    return $html;
  }
  public function how_to_guide_tool($attr, $content = ''){
    $attr = shortcode_atts(array(
      'img' => '',
      'img_alt' => ''
    ), $attr);

    $content = do_shortcode($content);

    $allow_schema = $this->config->read('vendors/schema');
    $html = '';

    if(!empty($attr['img'])){
      $img_alt = (!empty($attr['img_alt'])) ? $attr['img_alt'] : $content;

      $html .= '<span class="how-to-guide-tool"'. (($allow_schema) ? ' itemprop="tool" itemscope itemtype="http://schema.org/HowToTool"' : '') .'>';
      $html .= ($allow_schema) ? '<span itemprop="name">' : '';
      $html .= $content;
      $html .= ($allow_schema) ? '</span>' : '';
      $html .= '<img src="'. $attr['img'] .'" alt="'. $img_alt .'" itemprop="image" class="hidden" />';
      $html .= '</span>';
    }
    else{
      $html .= '<span class="how-to-guide-tool"'. (($allow_schema) ? ' itemprop="tool"' : '') .'>';
      $html .= $content;
      $html .= '</span>';
    }

    return $html;
  }
  public function how_to_guide_supply($attr, $content = ''){
    $attr = shortcode_atts(array(
      'img' => '',
      'img_alt' => ''
    ), $attr);

    $content = do_shortcode($content);
    $allow_schema = $this->config->read('vendors/schema');

    $html = '';

    if(!empty($attr['img'])){
      $img_alt = (!empty($attr['img_alt'])) ? $attr['img_alt'] : $content;

      $html .= '<span class="how-to-guide-supply"'. (($allow_schema) ? ' itemprop="supply" itemscope itemtype="http://schema.org/HowToSupply"' : '') .'>';
      $html .= ($allow_schema) ? '<span itemprop="name">' : '';
      $html .= $content;
      $html .= ($allow_schema) ? '</span>' : '';
      $html .= '<img src="'. $attr['img'] .'" alt="'. $img_alt .'" itemprop="image" class="hidden" />';
      $html .= '</span>';
    }
    else{
      $html .= '<span class="how-to-guide-supply"'. (($allow_schema) ? ' itemprop="supply"' : '') .'>';
      $html .= $content;
      $html .= '</span>';
    }

    return $html;
  }
  public function how_to_guide_step($attr, $content = ''){
    $attr = shortcode_atts(array(
      'heading' => '',
      'position' => '',
      'tag' => 'h3'
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $html  = '<div class="how-to-step"'. (($allow_schema) ? ' itemprop="step" itemscope itemtype="http://schema.org/HowToSection"' : '') .'>';
    $html .= '<'. $attr['tag'] .' class="how-to-step-heading"><span class="how-to-step-heading-label">Step '. $attr['position'] .':</span> <span'. (($allow_schema) ? ' itemprop="name"' : '') .'>'. $attr['heading'] .'</span></'. $attr['tag'] .'>';
    $html .= ($allow_schema) ? '<meta itemprop="position" content="'. $attr['position'] .'" />' : '';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;
  }
  public function how_to_guide_step_inner($attr, $content = ''){
    $attr = shortcode_atts(array(
      'position' => ''
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $html  = '<div class="how-to-step-inner"'. (($allow_schema) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/HowToStep"' : '') .'>';
    $html .= ($allow_schema) ? '<meta itemprop="position" content="'. $attr['position'] .'" />' : '';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;
  }
  public function how_to_guide_step_direction($attr, $content = ''){
    $attr = shortcode_atts(array(
      'position' => ''
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $html  = '<div class="how-to-step-direction"'. (($allow_schema) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/HowToDirection"' : '') .'>';
    $html .= ($allow_schema) ? '<meta itemprop="position" content="'. $attr['position'] .'" />' : '';
    $html .= '<p><span itemprop="text">'. do_shortcode($content) .'</span></p>';
    $html .= '</div>';

    return $html;
  }
  public function how_to_guide_step_tip($attr, $content = ''){
    $attr = shortcode_atts(array(
      'position' => '',
      'label' => 'Tip'
    ), $attr);

    $allow_schema = $this->config->read('vendors/schema');

    $label = (!empty($attr['label'])) ? '<span class="how-to-step-tip-label f-w-bold">'. $attr['label'] .':</span>' : '';

    $html  = '<div class="how-to-step-direction"'. (($allow_schema) ? ' itemprop="itemListElement" itemscope itemtype="http://schema.org/HowToTip"' : '') .'>';
    $html .= ($allow_schema) ? '<meta itemprop="position" content="'. $attr['position'] .'" />' : '';
    $html .= '<p>'. $label .' <span itemprop="text">'. do_shortcode($content) .'</span></p>';
    $html .= '</div>';

    return $html;
  }
  public function icon_box($attr, $content){
    $attr = shortcode_atts(array(
      'icon' => '',
      'class' => 'default',
      'heading' => '',
      'link' => '',
      'link_text' => '',
      'icon_type' => 'icon'
    ), $attr);

    $class = (!empty($attr['class'])) ? 'icon-box ' . $attr['class'] : 'icon-box';

    $html  = '<div class="'. $class .'">';
    $html .= (!empty($attr['link'])) ? '<a href="'. $attr['link'] .'" title="'. $attr['heading'] .'" class="icon-box-link">' : '';
    $html .= '<div class="icon-box-wrapper">';
    $html .= '<div class="icon-box-icon-area">';

    if($attr['icon_type'] != 'icon'){
      $html .= do_shortcode('[img src="'. $attr['icon'] .'" alt="'. $attr['heading'] .' Icon"]');
    }
    else{
      $html .= '<i class="'. $attr['icon'] .'"></i>';
    }
    
    $html .= '</div>';
    $html .= '<div class="icon-box-content-area">';

    if(!empty($attr['heading'])){
      $html .= '<h4 class="heading">'. $attr['heading'] .'</h4>';
    }
    
    $html .= (!empty($attr['link'])) ? '<span class="link">Learn More <i class="fa fa-long-arrow-right"></i></span>' : '';
    $html .= (!empty($content)) ? '<p class="content">'. $content .'</p>' : '';
    $html .= '</div>';
    $html .= '</div>';
    $html .= (!empty($attr['link'])) ? '</a>' : '';
    $html .= '</div>';

    return $html;
  }
  public function package_box($attr){
    $attr = shortcode_atts(array(
      'icon' => '',
      'plan' => '',
      'monthly_price' => '',
      'recommended' => 'no',
      'sta' => '',
      'ctr' => '',
      'cs' => '',
      'ptr' => '',
      'mtd' => '',
      'payroll' => '',
      'rb' => '',
      'fhx' => '',
      'vr' => '',
      'xl' => '',
      'bk' => '',
      'link' => '',
      'link_text' => 'Learn More',
      'link_class' => 'btn btn-white',
      'class' => ''
    ), $attr);

    $class = (!empty($attr['class'])) ? 'package-box ' . $attr['class'] : 'package-box';
    $money_sign = (is_numeric($attr['monthly_price'])) ? $this->config->read('currency/sign') : '';
    $recommended = ($attr['recommended'] != 'no') ? ' <span class="recommended">(Recommended)</span>' : '';

    $sta = ($attr['sta'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $sta = ($attr['sta'] == '-') ? $attr['sta'] : $sta;

    $ctr = ($attr['ctr'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $ctr = ($attr['ctr'] == '-') ? $attr['ctr'] : $ctr;

    $cs = ($attr['cs'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $cs = ($attr['cs'] == '-') ? $attr['cs'] : $cs;

    $ptr = ($attr['ptr'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $ptr = ($attr['ptr'] == '-') ? $attr['ptr'] : $ptr;

    $mtd = ($attr['mtd'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $mtd = ($attr['mtd'] == '-') ? $attr['mtd'] : $mtd;

    $payroll = (!is_numeric($attr['payroll']) && $attr['payroll'] == 'no') ? '<i class="fa fa-times-circle"></i>' : $attr['payroll'];
    $payroll = ($attr['payroll'] == '-') ? $attr['payroll'] : $payroll;

    $rb = ($attr['rb'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $rb = ($attr['rb'] == '-') ? $attr['rb'] : $rb;

    $fhx = ($attr['fhx'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $fhx = ($attr['fhx'] == '-') ? $attr['fhx'] : $fhx;

    $vr = ($attr['vr'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $vr = ($attr['vr'] == '-') ? $attr['vr'] : $vr;

    $xl = ($attr['xl'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $xl = ($attr['xl'] == '-') ? $attr['xl'] : $xl;

    $bk = ($attr['bk'] == 'yes') ? '<i class="far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
    $bk = ($attr['bk'] == '-') ? $attr['bk'] : $bk;

    $html  = '<div class="'. $class .'">';
    $html .= do_shortcode('[img src="'. $attr['icon'] .'" alt="'. $attr['plan'] .' Icon" class="icon"]');
    $html .= '<ul class="table-list table-package-list">';
    $html .= '<li class="plan-li"><span class="plan">'. $attr['plan'] . $recommended .'</span></li>';
    $html .= '<li class="monthly-price-li"><span class="monthly-price">'. $money_sign . $attr['monthly_price'] .'<span class="vat">+VAT</span></span></li>';
    $html .= '<li class="sta-li"><span class="sta">'. $sta .'</span></li>';
    $html .= '<li class="ctr-li"><span class="ctr">'. $ctr .'</span></li>';
    $html .= '<li class="cs-li"><span class="cs">'. $cs .'</span></li>';
    $html .= '<li class="ptr-li"><span class="ptr">'. $ptr .'</span></li>';
    $html .= '<li class="mtd-li"><span class="mtd">'. $mtd .'</span></li>';
    $html .= '<li class="payroll-li"><span class="payroll">'. $payroll .'</span></li>';
    $html .= '<li class="rb-li"><span class="rb">'. $rb .'</span></li>';
    $html .= '<li class="fhx-li"><span class="fhx">'. $fhx .'</span></li>';
    $html .= '<li class="vr-li"><span class="vr">'. $vr .'</span></li>';
    $html .= '<li class="bk-li"><span class="bk">'. $bk .'</span></li>';
    $html .= '<li class="xl-li"><span class="xl">'. $xl .'</span></li>';
    $html .= '</ul>';
    $html .= '<a href="'. $attr['link'] .'" class="'. $attr['link_class'] .'" title="'. $attr['link_text'] .'">'. $attr['link_text'] .' <i class="fa fa-long-arrow-right"></i></a>';
    $html .= '</div>';

    return $html;
  }
  public function service_box($attr, $content){
    $attr = shortcode_atts(array(
      'img' => '',
      'heading' => '',
      'link' => '',
      'tag' => 'h3',
      'class' => ''
    ), $attr);

    $class = (!empty($attr['class'])) ? 'main-wrapper-area ' . $attr['class'] : 'main-wrapper-area';

    $html  = '<div class="'. $class .'">';
    $html .= '<div class="content-wrapper-area paroller" data-paroller-factor="-0.05" data-paroller-type="foreground" data-paroller-direction="vertical">';
    $html .= '<div class="content-wrapper wow fadeIn animated" data-wow-delay="0.25s">';
    $html .= '<'. $attr['tag'] .' class="headline">'. $attr['heading'] .'</'. $attr['tag'] .'>';
    $html .= '<p class="content">'. $content .'</p>';
    $html .= '<a href="'. $attr['link'] .'" class="btn btn-default btn-sm">View Service <i class="fa fa-long-arrow-right"></i></a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="img-wrapper-area wow fadeIn animated" data-wow-delay="0.5s">';
    $html .= '<div class="img-area paroller" data-paroller-factor="0.1" data-paroller-type="foreground" data-paroller-direction="vertical">';
    $html .= '<div class="img" style="background: url('. $attr['img'] .') center center / cover;"></div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
  public function scroll_down(){
    $html  = '<div class="scroll-down hidden-xs">';
    $html .= '<a href="javascript:void(0);" title="Srcoll Down">';
    $html .= '<i class="fal fa-angle-down"></i>';
    $html .= '</a>';
    $html .= '</div>';

    return $html;
  }
  public function xero_partnership(){
    $html  = '<a href="https://www.xero.com/uk/partner-programs/partners/partner-program/" title="In Partnertsip With Xero" class="xero-partnership" target="_blank" rel="nofollow noopener">';
    $html .= '<p class="f-c-white">In Partnertsip With</p>';
    $html .= '<img src="/wp-content/uploads/2019/06/xero-platinum-partner.png" alt="Xero">';
    $html .= '</a>';

    return $html;
  }
  public function company_logos($attr){
    $attr = shortcode_atts(array(
      'heading' => 'Trusted by over 600 businesses – big and small'
    ), $attr);

    $html  = '<div class="company-logos paroller" data-paroller-factor="-0.05" data-paroller-type="foreground" data-paroller-direction="vertical">';

    if(!empty($attr['heading'])){
      $html .= '<h3 class="heading wow animated fadeInDown" data-wow-delay="0.25s">'. $attr['heading'] .'</h3>';
    }
    
    $html .= '<ul>';
    $html .= '<li class="wow animated fadeInDown" data-wow-delay="0.5s"><img src="/wp-content/uploads/2019/06/gud-ideas.png" alt="Gud Ideas" /></li>';
    $html .= '<li class="wow animated fadeInDown" data-wow-delay="0.75s"><img src="/wp-content/uploads/2019/06/drivejohnsons.png" alt="driveJohnson\'s" /></li>';
    $html .= '<li class="wow animated fadeInDown" data-wow-delay="1s"><img src="/wp-content/uploads/2019/06/swift-drive.png" alt="Swift Drive" /></li>';
    $html .= '<li class="wow animated fadeInDown" data-wow-delay="1.25s"><img src="/wp-content/uploads/2019/06/cj-coatings.png" alt="CJ Coatings" /></li>';
    $html .= '<li class="wow animated fadeInDown" data-wow-delay="1.5s"><img src="/wp-content/uploads/2019/06/elevation-maintenance.png" alt="Elevation Maintenance" /></li>';
    $html .= '<li class="wow animated fadeInDown" data-wow-delay="1.75s"><img src="/wp-content/uploads/2019/06/datalan.png" alt="DataLan" /></li>';
    $html .= '</ul>';
    $html .= '</div>';

    return $html;
  }
  public function banner_clients_rating($attr, $content){
    $attr = shortcode_atts(array(
      'clients_num' => '',
      'rating' => '5',
      'rating_perc' => '100%'
    ), $attr);

    $rating = (int)$attr['rating'];

    $html  = '<div class="banner-rating">';
    $html .= '<div class="stars">';

    $ani_num = 1.5;

    for ($i = 0; $i < $rating; $i++){
      $html .= '<i class="fa fa-star wow animated fadeInDown" data-wow-delay="'. $ani_num .'s"></i>'; 

      $ani_num = $ani_num + 0.25;
    }

    $html .= '</div>';
    $html .= '<div class="text">';
    $html  .= '<p>Over <strong>'. $attr['clients_num'] .' clients</strong> handled by our Experts with <strong>'. $attr['rating_perc'] .'</strong> '. $attr['rating'] .' star reviews</p>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
  public function stat($attr, $content){
    $attr = shortcode_atts(array(
      'number' => '',
      'sign_before' => '',
      'sign_after' => '',
      'heading' => ''
    ), $attr);

    $sign_before = (!empty($attr['sign_before'])) ? '<span class="sign before">'. $attr['sign_before'] .'</span>' : '';
    $sign_after = (!empty($attr['sign_after'])) ? '<span class="sign after">'. $attr['sign_after'] .'</span>' : '';

    $html  = '<div class="stat">';
    $html .= '<span class="number">'. $sign_before .'<span class="count">'. $attr['number'] .'</span>'. $sign_after .'</span>';
    $html .= '<h4 class="heading">'. $attr['heading'] .'</h4>';
    $html .= '<p class="content">'. $content .'</p>';
    $html .= '</div>';

    return $html;
  }
  public function resource_loader($attr, $content = ''){
    $attr = shortcode_atts(array(
      'img' => '',
      'source' => '',
      'img_alt' => '',
      'type' => '',
      'tag' => 'iframe'
    ), $attr);

    $html  = '<div class="resource-loader" load-source="'. $attr['source'] .'" source-tag="iframe" style="background: url('. $attr['img'] .') center center / cover;">';
    $html .= '<div class="resource-content"></div>';

    if($attr['type'] == 'video'){
      $html .= '<a href="javascript:void(0);" title="Play Video" class="resource-loader-action play-button">';
      $html .= '<i class="fa fa-play"></i>';
      $html .= '</a>';
    }
    if($attr['type'] == 'map'){
      $html .= '<a href="javascript:void(0);" title="View Our Location" class="resource-loader-action btn btn-default">View Our Location</a>';
    }

    $html .= '</div>';

    return $html;
  }
  public function get_success_story_image(){
    if(is_single() && in_category(3)){
      $img = get_post_thumbnail_id(get_the_ID());
      $img = wp_get_attachment_image_src($img, 'full', true);
      $img = $img[0];

      return do_shortcode('[img src="'. $img .'" alt="'. get_the_title(get_the_ID()) .'"]');
    }
  }
  public function package_table(){
    $html  = '<div class="package-table-wrapper">';
    $html .= '<div class="package-table">';
    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label package-table-mute"></div>';
    $html .= '<div class="package-table-col package-table-value package-table-top sole">';
    $html .= '<div class="package-table-top-inner">';
    $html .= '<span class="text">Sole Trader  <span class="text-sm">Non MTD</span></span> <span class="price">From £40 <span class="vat">(+VAT)</span></span>';
    $html .= '</div>';
    $html .= '</div>';
       $html .= '<div class="package-table-col package-table-value package-table-top basic">';
    $html .= '<div class="package-table-top-inner">';
    $html .= '<span class="text">Sole Trader <span class="text-sm">MTD Compliant</span></span> <span class="price">£60 <span class="vat">(+VAT)</span></span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="package-table-col package-table-value package-table-top basic-alt">';
    $html .= '<div class="package-table-top-inner">';
    $html .= '<span class="text">Basic</span> <span class="price">£150 <span class="vat">(+VAT)</span></span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="package-table-col package-table-value package-table-top standard">';
    $html .= '<div class="package-table-top-inner">';
    $html .= '<span class="text">Standard</span> <span class="price">£275 <span class="vat">(+VAT)</span></span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="package-table-col package-table-value package-table-top professional">';
    $html .= '<div class="package-table-top-inner">';
    $html .= '<span class="text">Professional</span> <span class="price">£400 <span class="vat">(+VAT)</span></span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Sole Trader Accounts</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Limited Company Accounts & Company Tax Return</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Confirmation Statement & Registered Office</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Personal Tax Return & Tax Planning</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">MTD filing 4 quarters</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
     $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Payroll</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value">1</div>';
    $html .= '<div class="package-table-col package-table-value">5</div>';
    $html .= '<div class="package-table-col package-table-value">20</div>';
    $html .= '</div>';
	/*
    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Receipt Bank</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';
	*/
    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Free 2 Hours Xero & Receipt Bank Training</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">VAT Return Review & Submission</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

    $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Bookkeeping</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

        $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Xero Licence</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';

        $html .= '<div class="package-table-row">';
    $html .= '<div class="package-table-col package-table-label">Dext</div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-times-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '<div class="package-table-col package-table-value"><i class="far fa-check-circle"></i></div>';
    $html .= '</div>';
    
    $html .= '</div>';
    $html .= '</div>'; 

    return $html;
  }
}