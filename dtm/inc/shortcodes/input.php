<?php
class Input{
  function __construct(){
    // Load Shortcodes
    add_shortcode('input', array($this, 'input'));
    add_shortcode('button', array($this, 'button'));
  }
  public function input($attr, $content = ''){
    $attr = shortcode_atts(array(
      'type' => 'text',
      'name' => '',
      'required' => ''
    ), $attr);

    $type = (!empty($attr['type'])) ? ' type="'. $attr['type'] .'"' : '';
    $name = (!empty($attr['name'])) ? ' name="'. trim(str_replace(' ', '-', strtolower($attr['name']))) .'"' : '';
    $placeholder = (!empty($attr['name'])) ? ' placeholder="'. trim($attr['name']) .'"' : '';
    $required = ($attr['required'] == 'yes') ? ' required="required"' : '';
    $text = (!empty($attr['text'])) ? ' value="'. $attr['text'] .'"' : '';
    $class = (!empty($attr['name'])) ? ' class="form-input '. trim(str_replace(' ', '-', strtolower($attr['name']))) .'"' : '';

    $html  = '<div class="form-group">';
    $html .= '<input'. $type . $class . $name . $placeholder . $required .' />';
    $html .= '</div>';

    return $html;
  }
  public function button($attr){
    $attr = shortcode_atts(array(
      'text' => 'Get Started'
    ), $attr);

    $html = '<input type="submit" class="form-submit" value="'. $attr['text'] .'" />';

    return $html;
  }
}