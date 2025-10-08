<?php
class Action_box{
  function __construct(){
    // Load Shortcodes
    add_shortcode('action-box', array($this, 'action_box'));
    add_shortcode('action-box-heading', array($this, 'action_box_heading'));
    add_shortcode('action-box-content', array($this, 'action_box_content'));
  }
  public function action_box($attr, $content = ''){
    $attr = shortcode_atts(array(
      'class' => '',
      'bg_img' => '',
      'bg_gradient_x' => '',
      'bg_gradient_y' => '',
      'bg_position' => 'center center',
      'button_link' => '',
      'button_text' => 'Get Started',
      'button_class' => '',
      'form' => 'no'
    ), $attr);

    // Class
    $class  = 'action-box';
    $class .= (!empty($attr['class'])) ? ' ' . $attr['class'] : '';
    $class .= (!empty($attr['bg_img'])) ? ' action-box-img' : '';
    $class .= ($attr['form'] == 'yes') ? ' action-box-form' : '';

    if(empty($attr['bg_img']) && empty($attr['class'])){
      $class .= ' bg-c-default';
    }

    // BG
    $bg_gradient = '';

    if(!empty($attr['bg_gradient_x']) || !empty($attr['bg_gradient_y'])){
      $bg_gradient .= ' linear-gradient(';

      if(empty($attr['bg_gradient_x'])){
        $bg_gradient .= 'rgba('. $attr['bg_gradient_y'] .')';
        $bg_gradient .= ', rgba('. $attr['bg_gradient_y'] .')';
      }
      elseif(empty($attr['bg_gradient_y'])){
        $bg_gradient .= 'rgba('. $attr['bg_gradient_x'] .')';
        $bg_gradient .= ', rgba('. $attr['bg_gradient_x'] .')';
      }
      else{
        $bg_gradient .= 'rgba('. $attr['bg_gradient_x'] .')';
        $bg_gradient .= ', rgba('. $attr['bg_gradient_y'] .')';
      }

      $bg_gradient .= '),';
    }
    $bg_position = (!empty($attr['bg_position'])) ? $attr['bg_position'] : '';
    $bg_img = (!empty($attr['bg_img'])) ? ' url('. $attr['bg_img'] .') '. $bg_position .' / cover;' : '';

    $bg = '';

    if(!empty($bg_img)){
      $bg .= ' style="background:'. $bg_gradient . $bg_img .'"';
    }
    // Content
    $content = (!empty($content)) ? do_shortcode($content) : '';

    $link = '';
    if($attr['form'] == 'no'){
      // Link
      $button_link  = (!empty($attr['button_link'])) ? $attr['button_link'] : '';
      $button_class = (!empty($attr['button_class'])) ? 'btn ' . $attr['button_class'] : 'btn btn-secondary';
      if(!empty($button_link)){
        $link .= '<a href="'. $button_link .'" title="'. $attr['button_text'] .'" class="'. $button_class .'">'. $attr['button_text'] .'</a>';
      }
    }

    $html  = '<div class="'. trim($class) .'"' . $bg .'>';

    if($attr['form'] == 'yes'){
      $html .= '<form method="post">';
    }

    $html .= $content;

    if($attr['form'] == 'yes'){
      $html .= '<div class="form-repsonse"></div>';
      $html .= '</form>';
    }

    $html .= $link;
    $html .= '</div>';

    return $html;
  }
  public function action_box_heading($attr, $content = ''){
    $attr = shortcode_atts(array(
      'tag' => 'h3',
      'class' => ''
    ), $attr);

    $class = (!empty($attr['class'])) ? ' class="heading '. $attr['class'] .'"' : ' class="heading"';

    $html  = '<'. $attr['tag'] . $class .'>';
    $html .= do_shortcode($content);
    $html .= '</'. $attr['tag'] .'>';

    return $html;
  }
  public function action_box_content($attr, $content = ''){
    $attr = shortcode_atts(array(
      'class' => ''
    ), $attr);

    $class = (!empty($attr['class'])) ? ' class="content '. $attr['class'] .'"' : ' class="content"';

    $html  = '<p'. $class .'>';
    $html .= do_shortcode($content);
    $html .= '</p>';

    return $html;
  }
}