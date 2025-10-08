<?php
/**
 * Returns HTML For the class
 */
class Section{
  /**
   *  @var 
   */
  public $config;
  /**
   * 
   */
  function __construct($config){
    // Load Config from App
    $this->config = $config;
    // Load Shortcodes
    add_shortcode('section', array($this, 'section'));
    add_shortcode('row', array($this, 'row'));
    add_shortcode('col', array($this, 'col'));
  }
  public function section($attr, $content = null){
    $attr = shortcode_atts(array(
      'class' => '',
      'id' => '',
      'layout' => $this->config->read('theme/layout'),
      'tag' => 'section',
      'absolute_full_width' => 'no'
    ), $attr);

    // Section Classes
    $class  = 'sec';
    $class .= ($attr['layout'] != 'contained') ? ' sec-full-width' : ' sec-contained';
    $class .= ($attr['absolute_full_width'] == 'yes') ? ' sec-full-width-abs' : '';
    $class .= (!empty($attr['class'])) ? ' ' . $attr['class'] : '';
    $class  = ' class="'. trim($class) .'"';

    // Section Id
    $id = (!empty($attr['id'])) ? ' id="'. $attr['id'] .'"' : '';

    // Layout
    $layout = ($attr['layout'] != 'contained') ? 'gi-container-fluid' : 'gi-container';

    // Section HTML
    $html  = '<'. $attr['tag'] . $class . $id .'>';
    $html .= '<div class="'. $layout .'">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    $html .= '</'. $attr['tag'] .'>';

    return $html;
  }
  public function row($attr, $content = null){
    $attr = shortcode_atts(array(
      'class' => '',
      'id' => ''
    ), $attr);

    // Row Classes
    $class = (!empty($attr['class'])) ? 'gi-row ' . $attr['class'] : 'gi-row';
    $class = ' class="'. $class .'"';

    // Row Id
    $id = (!empty($attr['id'])) ? ' id="'. $attr['id'] .'"' : '';

    // Row HTML
    $html  = '<div'. $class . $id .'>';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;
  }
  public function col($attr, $content = null){
    $attr = shortcode_atts(array(
      'class' => '',
      'id' => '',
      'size' => '12'
    ), $attr);

    // Col Classes
    $class  = (!empty($attr['class'])) ? 'gi-col-sm-' . $attr['size'] . ' ' . $attr['class'] : 'gi-col-sm-' . $attr['size'];
    $class  = ' class="'. $class .'"';

    // Col Id
    $id = (!empty($attr['id'])) ? ' id="'. $attr['id'] .'"' : '';

    // Col HTML
    $html  = '<div'. $class . $id .'>';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;
  }
}
