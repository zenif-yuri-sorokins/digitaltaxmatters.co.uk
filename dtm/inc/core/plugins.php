<?php
  class Plugins extends App{
  	function _construct(){
      $this->filters();
    }
    private function filters(){
      // Remove break tags from Contact Form 7
      if($this->config->read('vendors/cf7')){
        add_filter('wpcf7_autop_or_not', '__return_false');
      }
      // Remove meta data for Revolution Slider
      if($this->config->read('vendors/rev_slider')){
        add_filter('revslider_meta_generator', array($this, 'remove_revslider_meta_tag'));
      }
      // Remove meta data for Visual Composer
      if($this->config->read('vendors/visual_composer')){
        add_action('wp_head', array($this, 'remove_vc_generator_tag'), 1);
      }
      // Remove meta data for SEO Yoast
      if($this->config->read('vendors/seo_yoast')){
        add_filter('wpseo_json_ld_output', array($this, 'remove_seo_yoast_schema'), 10, 1);
        add_action('wp_head', array($this, 'remove_seo_yoast_comments'), ~PHP_INT_MAX);
      }
      // Remove default styles for WooCommerce
      if($this->config->read('vendors/woocommerce')){
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
      }
    }
    /* Remove Revslider Generator */
    public function remove_revslider_meta_tag(){
      return '';
    }
    // Remove SEO Yoast Schema
    public function remove_seo_yoast_schema(){
      $data = array();
      return $data;
    }
    // Remove SEO Yoast Comments
    public function remove_seo_yoast_comments(){
      ob_start(function($o){
        return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi', '', $o);
      });
    }
    public function remove_vc_generator_tag(){
        remove_action('wp_head', array(visual_composer(), 'addMetaData'));
    }
  }