<?php
class Shortcodes extends App{
  public $config;
  private $exclude = array(
    '.',
    '..'
  );
  private $class_instances = array();

  function _construct(){
    if($this->config->read('vendors/shortcode_section') == false){
      $this->exclude[] = 'section.php';
    }
    add_filter("the_content", array($this, "filter_content"));
  }
  public function load_shortcodes(){
    $dir = ROOT . '/inc/shortcodes';

    if(is_dir($dir)){
      $files = scandir($dir);

      if(count($files) > 0){
        foreach($files as $file){
          if(!in_array($file, $this->exclude)){
            $this->load($dir, $file);
          }
        }
        foreach($this->class_instances as $class_var => $class_name){
          $class_ver = new $class_name($this->config);
        }
      }
    }
  }
	private function load($dir, $file){
    require_once $dir . '/' . $file;

    $file = explode('.', $file);
    $file = $file[0];

    $this->class_instances[$file] = ucwords($file);
	}
  private function get_all_shortcodes(){
    global $shortcode_tags;
    $shortcodes = '';

    foreach($shortcode_tags as $key => $shortcode){
      $shortcodes .= $key . " ";
    }
    return $shortcodes = explode(" ", trim($shortcodes));
  }
  public function filter_content($content){
    // Array of custom shortcodes requiring the fix
    $block = join("|", $this->get_all_shortcodes());

    // Opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

    // Closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);

    return $rep;
  }
}
