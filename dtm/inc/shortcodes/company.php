<?php
class Company{
  private $config;

  function __construct($config){
    // Load Config
    $this->config = $config;

    // Load Shortcodes
    add_shortcode('company-name', array($this, 'name'));
    add_shortcode('company-telephone', array($this, 'telephone'));
    add_shortcode('company-email', array($this, 'email'));
    add_shortcode('company-address', array($this, 'address'));
    add_shortcode('company-contact-details', array($this, 'contact_details'));
    add_shortcode('company-social-links', array($this, 'social_links'));
    add_shortcode('company-what-they-do', array($this, 'what_they_do'));
    add_shortcode('company-opt-out-email', array($this, 'opt_out_email'));
  }

  public function name(){
    if($this->config->read('company/name')){
      return $this->config->read('company/name');
    }
  }
  public function telephone($attr){
  	$attr = shortcode_atts(array(
  		'plain' => false
  	), $attr);

  	if($this->config->read('company/telephone')){
      $html = '';

      if($attr['plain'] != true){
        $html  = '<a href="tel:'. str_replace(' ', '', $this->config->read('company/telephone')) .'" title="Call '. $this->config->read('company/name') .'">';
        $html .= $this->config->read('company/telephone');
        $html .= '</a>';
      }
      else{
        $html = $this->config->read('company/telephone');
      }

     return $html;
    }
  }
  public function email($attr){
    $attr = shortcode_atts(array(
      'plain' => false
    ), $attr);

    if($this->config->read('company/email')){
      $html = '';

      if($attr['plain'] != true){
        $html  = '<a href="mailto:'. str_replace(' ', '', $this->config->read('company/email')) .'" title="Email '. $this->config->read('company/name') .'">';
        $html .= $this->config->read('company/email');
        $html .= '</a>';
      }
      else{
        $html = $this->config->read('company/email');
      }

      return $html;
    }
  }
  public function address($attr){
    $attr = shortcode_atts(array(
      'address_link' => ''
    ), $attr);

    if($this->config->read('company/address')){
      $line_one = (!empty($this->config->read('company/address/line_one'))) ? $this->config->read('company/address/line_one') : '';
      $line_two = (!empty($this->config->read('company/address/line_two'))) ? $this->config->read('company/address/line_two') : '';
      $city = (!empty($this->config->read('company/address/city'))) ? $this->config->read('company/address/city') : '';
      $country = (!empty($this->config->read('company/address/country'))) ? $this->config->read('company/address/country') : '';
      $postcode = (!empty($this->config->read('company/address/postcode'))) ? $this->config->read('company/address/postcode') : '';

      $html = '';

      if(!empty($attr['address_link'])){
       $html .= '<a href="'. $attr['address_link'] .'" title="'. $this->config->read('company/name') .'\'s Address" target="_blank" rel="noopener">';
      }

      $html .= $line_one . ', ' . $line_two . ', ' . $city . ', ' . $city;

      if(!empty($attr['address_link'])){
        $html .= '</a>';
      }

      return $html;
    }
  }
  public function contact_details($attr){
    $attr = shortcode_atts(array(
      'telephone' => '',
      'email' => '',
      'line_one' => '',
      'line_two' => '',
      'city' => '',
      'country' => '',
      'postcode' => '',
      'address_link' => ''
    ), $attr);

    $telephone = (!empty($this->config->read('company/telephone'))) ? $this->config->read('company/telephone') : $attr['telephone'];
    $telephone = '<a href="tel:'. str_replace(' ', '', $telephone) .'" title="Call '. $this->config->read('company/name') .'">'. $telephone .'</a>';

    $email = (!empty($this->config->read('company/email'))) ? $this->config->read('company/email') : $attr['email'];
    $email = '<a href="mailto:'. $email .'" title="Email '. $this->config->read('company/name') .'">'. $email .'</a>';

    $line_one = (!empty($this->config->read('company/address/line_one'))) ? $this->config->read('company/address/line_one') : '';
    $line_two = (!empty($this->config->read('company/address/line_two'))) ? $this->config->read('company/address/line_two') : '';
    $city = (!empty($this->config->read('company/address/city'))) ? $this->config->read('company/address/city') : '';
    $country = (!empty($this->config->read('company/address/country'))) ? $this->config->read('company/address/country') : '';
    $postcode = (!empty($this->config->read('company/address/postcode'))) ? $this->config->read('company/address/postcode') : '';

    $address = '';

    if(!empty($line_one)){
      $address .= ($this->config->read('vendors/schema')) ? '<span itemprop="streetAddress">'. $line_one . '</span>' : '<span>'. $line_one . '</span>';
    }
    if(!empty($line_two)){
      $address .= ($this->config->read('vendors/schema')) ? ', <span itemprop="addressLocality">'. $line_two . '</span>' : ', <span>'. $line_two . '</span>, ';
    }
    if(!empty($city)){
      $address .= ($this->config->read('vendors/schema')) ? ', <span itemprop="addressRegion">'. $city . '</span>' : ', <span>'. $city . '</span>, ';
    }
    if(!empty($country)){
      $address .= ($this->config->read('vendors/schema')) ? '<meta itemprop="addressCountry" content="'. $country . '" />' : '';
    }
    if(!empty($postcode)){
      $address .= ($this->config->read('vendors/schema')) ? ', <span itemprop="addressCountry">'. $postcode . '</span>' : ', <span>'. $postcode . '</span>';
    }
    if(!empty($attr['address_link'])){
      $address = '<a href="'. $attr['address_link'] .'" title="'. $this->config->read('company/name') .'\'s Address" target="_blank" rel="noopener">' . $address . '</a>';
    }

    $html = '';

    if($this->config->read('vendors/schema')){
      $html .= '<div itemscope itemtype="http://schema.org/Organization">';
      $html .= '<meta itemprop="name" content="'. $this->config->read('company/name') .'">';
      $html .= '<meta itemprop="image" content="'. $this->config->read('company/logo') .'">';
    }

    $telephone = ($this->config->read('vendors/schema')) ? '<li itemprop="telephone"><span class="label">t.</span> '. $telephone .'</li>' : '<li><span class="label">Telephone:</span> ' . $telephone . '</li>';
    $email = ($this->config->read('vendors/schema')) ? '<li itemprop="email"><span class="label">e.</span> '. $email .'</li>' : '<li><span class="label">Email:</span> ' . $email . '</li>';
    $address = ($this->config->read('vendors/schema')) ? '<li itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span class="label">a.</span> ' . $address . '</li>' : '<li><span class="label">a.</span> ' . $address . '</li>';

    $html .= '<ul>';
    $html .= $telephone;
    $html .= $email;
    $html .= $address;
    $html .= '</ul>';

    if($this->config->read('vendors/schema')){
      $html .= '</div>';
    }

    return $html;
  }
  public function social_links($attr){
    $attr = shortcode_atts(array(
      'include' => '',
      'class' => ''
    ), $attr);

    if($this->config->read('company/social_media')){
      $class = (!empty($attr['class'])) ? 'social ' . $attr['class']  : 'social';

      if(!empty($attr['include'])){
        $include = explode(',', $attr['include']);
        $include = array_map('trim', $include);
      }
      
      $html = '<ul class="'. $class .'">';

      foreach($this->config->read('company/social_media') as $social_media => $link){
        if(!empty($link)){
          $title = ucwords(str_replace('-', ' ', $social_media));
          $title = $this->config->read('company/name') . '\'s ' . $title;

          if($social_media == 'google-plus'){
            $title = $this->config->read('company/name') . '\'s Google+';
          }

          $icon = 'fab fa-' . $social_media;

          if($social_media == 'facebook'){
            $icon .= '-f';
          }
          if($social_media == 'google-plus'){
            $icon .= '-g';
          }
          if($social_media == 'linkedin'){
            $icon .= '-in';
          }
          if($social_media == 'pinterest'){
            $icon .= '-p';
          }

          if(empty($include)){
            $html .= '<li>';
            $html .= '<a href="'. $link .'" title="'. $title .'" target="_blank" rel="noopener">';
            $html .= '<i class="'. $icon .'"></i>';
            $html .= '</a>';
            $html .= '</li>';
          }
          else{
            if(in_array($social_media, $include)){
              $html .= '<li>';
              $html .= '<a href="'. $link .'" title="'. $title .'" target="_blank" rel="noopener">';
              $html .= '<i class="'. $icon .'"></i>';
              $html .= '</a>';
              $html .= '</li>';
            }
          }
        }
      }

      $html .= '</ul>';
    
      return $html;
    }
  }
  public function what_they_do($attr){
    $attr = shortcode_atts(array(
      'allow_html' => 'yes',
      'class' => ''
    ), $attr);

    $class = (!empty($attr['class'])) ? ' class="' . $attr['class'] . '"' : '';

    $html  = ($attr['allow_html'] == 'yes') ? '<p'. $class .'>' : '';
    $html .= $this->config->read('company/what_they_do');
    $html .= ($attr['allow_html'] == 'yes') ? '</p>' : '';

    return $html;
  }
  public function opt_out_email($attr){
    $attr = shortcode_atts(array(
      'allow_html' => 'yes'
    ), $attr);

    $class = (!empty($attr['class'])) ? ' class="' . $attr['class'] . '"' : '';

    $html  = ($attr['allow_html'] == 'yes') ? '<a href="mailto:'. $this->config->read('company/opt_out_email') .'" title="'. $this->config->read('company/name') .'\'s Opt-out Email">' : '';
    $html .= $this->config->read('company/opt_out_email');
    $html .= ($attr['allow_html'] == 'yes') ? '</a>' : '';

    return $html;
  }
}