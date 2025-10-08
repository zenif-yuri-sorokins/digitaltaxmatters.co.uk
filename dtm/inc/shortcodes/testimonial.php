<?php
class Testimonial{
  private $config;

  function __construct($config){
    // Load Config
    $this->config = $config;

    // Load Shortcodes
    add_shortcode('testimonial', array($this, 'testimonial'));
    add_shortcode('testimonial-heading', array($this, 'heading'));
    add_shortcode('testimonial-content', array($this, 'content'));
    add_shortcode('testimonial-aggregate', array($this, 'aggregate'));
    add_shortcode('testimonial-box', array($this, 'testimonial_box'));
  }
  public function testimonial($attr, $content = null){
    $attr = shortcode_atts(array(
      'class' => '',
      'id' => '',
      'styled' => false,
      'name' => 'John Doe',
      'date' => date('jS M Y', strtotime("now"))
    ), $attr);

    // Testimonial Class
    $class  = (!empty($attr['class'])) ? 'testimonial ' . $attr['class'] : 'testimonial';
    $class .= ($attr['styled'] == true) ? ' style' : '';
    $class  = ' class="'. $class .'"';

    // Testimonial ID
    $id = (!empty($attr['id'])) ? ' id="'. $attr['id'] .'"' : '';

    // Testimonial Schema
    $schema = ($this->config->read('vendors/schema')) ? ' itemprop="review" itemscope itemtype="http://schema.org/Review"' : '';

    // Testimonial HTML
    $html  = '<div'. $class . $id . $schema .'>';
    $html .= do_shortcode($content);
    $html .= '<div class="details">';
    
    $html .= '<div  class="name" ';
    $html .= ($this->config->read('vendors/schema')) ? '  itemscope itemprop="author" itemtype="http://schema.org/Person">' : '>';
      $html .= '<span itemprop="name">';
        $html .= $attr['name'];
      $html .= '</span>';
    $html .= '</div>';
    $html .= '<span class="rating"';
    $html .= ($this->config->read('vendors/schema')) ? ' itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">' : '>';

    if($this->config->read('vendors/schema')){
      $html .= '<meta itemprop="worstRating" content="1">';
      $html .= '<meta itemprop="bestRating" content="5" />';
      $html .= '<meta itemprop="ratingValue" content="5" />';
    }

    $html .= str_repeat('<i class="fa fa-star"></i>', 5) .'</span>';
    $html .= '<span class="date"';
    $html .= ($this->config->read('vendors/schema')) ? ' itemprop="datePublished" content="'. date('Y-m-d', strtotime($attr['date'])) .'">' : '>';
    $html .= $attr['date'];
    $html .= '</span>';

    if($this->config->read('vendors/schema')){
      $html .= '<div itemprop="publisher" itemscope itemtype="http://schema.org/Organization">';
      $html .= '<meta itemprop="name" content="'. $this->config->read('company/name') .'"></div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
  public function heading($attr, $content= null){
    $attr = shortcode_atts(array(
      'class' => '',
      'tag' => 'h3'
    ), $attr);

    // Heading Class
    $class  = (!empty($attr['class'])) ? 'heading ' . $attr['class'] : 'heading';
    $class  = ' class="'. $class .'"';

    // Heading Schema
    $schema = ($this->config->read('vendors/schema')) ? ' itemprop="name"' : '';

    // Heading HTML
    $html  = ($this->config->read('vendors/schema')) ? '<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Organization">' : '';
    $html .= '<'. $attr['tag'] . $class . $schema .'>';
    $html .= do_shortcode($content);
    $html .= '</'. $attr['tag'] .'>';
    $html .= ($this->config->read('vendors/schema')) ? '</div>' : '';

    return $html;
  }
  public function content($attr, $content = null){
    $attr = shortcode_atts(array(
      'class' => ''
    ), $attr);

    // Heading Class
    $class  = (!empty($attr['class'])) ? 'content ' . $attr['class'] : 'content';
    $class  = ' class="'. $class .'"';

    // Heading HTML
    $html  = '<p' . $class .'>"';
    $html .= ($this->config->read('vendors/schema')) ? '<span itemprop="reviewBody">' : '';
    $html .= do_shortcode($content);
    $html .= ($this->config->read('vendors/schema')) ? '</span>' : '';
    $html .= '"</p>';

    return $html;
  }
  public function aggregate($attr){
    $attr = shortcode_atts(array(
      'rating' => '5',
      'count' => '',
      'tag' => 'p',
      'class' => 'hidden'
    ), $attr);

    if($this->config->read('vendors/schema')){
      // Aggregate Class
      $class = (!empty($attr['class'])) ? 'aggregate '. $attr['class'] .'"' : 'aggregate';
      $class = ' class="'. $class .'"';

      // Aggregate HTML
      $html  = '<'. $attr['tag'] . $class .' itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
        $html .= '<span itemprop=itemReviewed itemscope itemtype=http://schema.org/Organization><span class="heading hidden" itemprop="name">Client Testimonial</span></span>';
      $html .= '<span itemprop="name">'. $this->config->read('company/name') .'</span> are rated';
      $html .= ' <span itemprop="ratingValue">'. $attr['rating'] .'</span>/5 based on';
      $html .= ' <span itemprop="reviewCount">'. $attr['count'] .'</span> reviews';
      $html .= '</'. $attr['tag'] .'>';

      return $html;
    }
    return '';
  }
  public function testimonial_box($attr, $content = null){
    $attr = shortcode_atts(array(
      'name' => '',
      'img' => '',
      'role' => '',
      'logo' => '',
      'logo_company' => '',
      'date' => '',
      'no_img' => 'no'
    ), $attr);

    $class = ($attr['no_img'] == 'yes') ? 'testimonial-box no-img' : 'testimonial-box';

    $img = (!empty($attr['img'])) ? do_shortcode('[img src="'. $attr['img'] .'" alt="'. $attr['name'] .'" class="img"]') : '';
    $role = (!empty($attr['role'])) ? '<p class="role">'. $attr['role'] .'</p>' : '';
    $logo = (!empty($attr['logo'])) ? '<img src="'. $attr['logo'] .'" alt="'. $attr['logo_company'] .'" class="logo" />' : '';

    $html  = '<div class="'. $class .'" itemprop="review" itemscope itemtype="http://schema.org/Review">';
    $html .= '<div class="hidden" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Organization">Client Testimonial</div>';

    if($attr['no_img'] != 'yes'){
      $html .= '<div class="testimonial-box-img '. str_replace(' ', '-', strtolower($attr['name'])) .'"></div>';
    }


    $html .= '<div class="testimonial-box-content">';
    $html .= '<p>"<span itemprop="reviewBody">'. $content .'</span>"</p>';
    $html .= $img;
    $html .= '<p class="name" itemscope itemprop="author" itemtype="http://schema.org/Person">';
      $html .= '<span itemprop="name">';
        $html .= $attr['name'];
      $html .= '</span>';
    $html .= '</p>';
	  
	if(is_front_page()){
		$html .= $role;
	}
    
    $html .= $logo;
    $html .= '<meta itemprop="datePublished" content="'. date('Y-m-d', strtotime($attr['date'])) .'">';
    $html .= '<div class="rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">';
    $html .= '<meta itemprop="worstRating" content="1">';
    $html .= '<meta itemprop="bestRating" content="5" />';
    $html .= '<meta itemprop="ratingValue" content="5" />';
    $html .= '</div>';
    $html .= '<div itemprop=itemReviewed itemscope itemtype=http://schema.org/Organization><span class="heading hidden" itemprop="name">Client Testimonial</span></div>';
    $html .= '<div itemprop="publisher" itemscope itemtype="http://schema.org/Organization"><meta itemprop="name" content="'. $this->config->read('company/name') .'"></div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
}
