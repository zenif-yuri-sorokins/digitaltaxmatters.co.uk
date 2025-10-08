<?php
class Menu extends App{
    function _construct(){
         $this->loader('navmenu', false);
    }
    public function menu_output($theme_location = 'primary'){
        wp_nav_menu(array(
            'container_class' => 'menu-header', 
            'theme_location' => $theme_location, 
            'walker' => new Navmenu($this->config)
        ));
    }
}