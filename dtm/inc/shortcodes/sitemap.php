<?php
class Sitemap{
  private $exclude_pages = array('Sitemap');

  function __construct(){
    // Load Shortcodes
    add_shortcode('sitemap-links', array($this, 'links'));
  }
  public function links(){
    if(count($this->exclude_pages) > 0){
      $exclude_pages_ids = '';
      $i = 0;

      foreach($this->exclude_pages as $page){
        $exclude_pages_ids .= $this->get_page_id_by_title($page);

        if($i < (count($this->exclude_pages) - 1)){
          $exclude_pages_ids .= ',';
        }
      }

      $html  = '<h2 class="headline">All Our Web Pages</h2>';
      $html .= '<ul class="sitemap-links">';
      $html .= wp_list_pages(array(
        'echo' => false,
        'exclude' => $exclude_pages_ids,
        'title_li' => null
      ));
      $html .= '</ul>';

      return $html;
    }
  }
  private function get_page_id_by_title($title = ''){
    if(!empty($title)){
      $page_id = get_page_by_title($title);
      $page_id = $page_id->ID;

      return $page_id;
    }
  }
}