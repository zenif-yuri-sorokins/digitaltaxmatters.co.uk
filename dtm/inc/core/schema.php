<?php
	class Schema extends App{
		private $main;
		private $website;
		private $post;

		function _construct(){
			// Main Schema Data
			$this->main = array(
				'name' => $this->config->read('company/name'),
				'@id' => $this->config->read('base_url'),
				'logo' => $this->config->read('company/logo'),
				'url'  => $this->config->read('base_url'),
				'email' => $this->config->read('company/email'),
				'telephone' => $this->config->read('company/telephone'),
				'legalName' => $this->config->read('company/name'),
				'contactPoint' => array(
					'@type' => 'ContactPoint',
					'telephone' => preg_replace('/^0?/', '+'. '44', $this->config->read('company/telephone')),
					'contactType' => 'Customer Service'
				),
			);

			// Default Schema
			$this->add_address();
			$this->add_geo_location();
			$this->add_social_media();
			$this->add_opening_times();
			$this->add_aggregate_rating();
			$this->add_company_shema();

			// Website Schema Data
			$this->website = array(
				'name' => $this->config->read('company/name'),
				'url'  => $this->config->read('base_url')
			);

			// Get Post ID
			$_posts = new Posts();
			$this->post = $_posts;
		}
		// Create Schema
		private function create($type = '', $options = array()){
			$schema = array(
				'@context' => 'http://schema.org/',
				'@type' => $type
			);

			if(count($options)){
				foreach($options as $key => $option){
					$schema[$key] = $option;
				}
				return $schema;
			}
			return '';
		}
		// Encode Schema Array into JSON
		private function encode_schema($schema = array()){
			if(count($schema)){
				return json_encode($schema);
			}
		}
		// Render Schema Data
		public function render($type, $options = array()){
			$schema = array();
			$main = $this->main;
			$website = $this->website;

			// Load Extra Information
			if(count($options)){
				foreach($options as $key => $option){
					$main[$key] = $option;
				}
			}

			// Create Schema
			$schema[] = $this->create($type, $main);
			$schema[] = $this->create('Website', $website);

			// Encode Schema
			$schema = stripslashes($this->encode_schema($schema));

			// Return Schema
			$html  = '<script type="application/ld+json">';
			$html .= $schema;
			$html .= '</script>';

			return $html;
		}
		// Add Address to Schema
		private function add_address(){
			// -> Add Address Line 1
			if($this->config->read('company/address/line_one')){
				$this->main['address'] = array(
					'@type' => 'PostalAddress'
				);
				$this->main['address']['streetAddress'] = $this->config->read('company/address/line_one');
			}
			// -> Add Address Line 2
			if($this->config->read('company/address/line_two')){
				$this->main['address']['addressLocality'] = $this->config->read('company/address/line_two');
			}
			// -> Add City
			if($this->config->read('company/address/city')){
				$this->main['address']['addressRegion'] = $this->config->read('company/address/city');
			}
			// -> Add Postcode
			if($this->config->read('company/address/postcode')){
				$this->main['address']['postalCode'] = $this->config->read('company/address/postcode');
			}
			// -> Add Country
			if($this->config->read('company/address/country')){
				$this->main['address']['addressCountry'] = array(
					'@type' => 'Country',
					'name'	=> $this->config->read('company/address/country')
				);
			}
		}
		// Add Geo Location to Schema
		private function add_geo_location(){
			if(!empty($this->config->read('company/geo/lat')) && !empty($this->config->read('company/geo/long'))){
				$this->main['geo'] = array(
					'@type' => 'GeoCoordinates',
					'latitude' => $this->config->read('company/geo/lat'),
					'longitude' => $this->config->read('company/geo/long')
				);
			}
		}
		// Add Social Media Links to Schema
		private function add_social_media(){
			if($this->config->read('company/social_media')){
				$links = array();

				foreach($this->config->read('company/social_media') as $link){
					$links[] = $link;
				}

				if(count($links) > 0){
					$this->main['sameAs'] = $links;
				}
			}
		}
		// Add Opening Times to Website
		private function add_opening_times(){
			if($this->config->read('company/opening_times')){
				$opeining_times = array();

				foreach($this->config->read('company/opening_times') as $times){
					$opeining_times[] = array(
						'@type' => 'OpeningHoursSpecification',
						'dayOfWeek' => $times['days'],
						'opens' => $times['opens'],
						'closes' => $times['closes']
					);
				}

				if(count($opeining_times) > 0){
					$this->main['openingHoursSpecification'] = $opeining_times;
				}
			}
		}
		// Add Aggregate Rating
		private function add_aggregate_rating(){
			if($this->config->read('company/rating') && $this->config->read('company/rating/count') > 0){
				$this->main['aggregateRating'] = array(
					'@type' => 'AggregateRating',
					'ratingValue' => $this->config->read('company/rating/average'),
					'bestRating' => '5',
					'worstRating' => '1',
					'ratingCount' => $this->config->read('company/rating/count')
				);
			}
		}
		// Add Other Company Schema Data
		private function add_company_shema(){
			$data = array();

			// Add Company Iamge
			if($this->config->read('company/schema_image')){
				$data['image'] = $this->config->read('company/schema_image');
			}

			// Add Company Price Range
			if($this->config->read('company/price_range')){
				$data['priceRange'] = $this->config->read('company/price_range');
			}

			// Add Potential Action
			if($this->config->read('action/url')){
				$data['potentialAction'] = array(
					'@type' => 'ReserveAction',
					'target' => array(
						'@type' => 'EntryPoint',
						'urlTemplate' => $this->config->read('action/url'),
						'inLanguage' => $this->config->read('lang'),
						'actionPlatform' => array(
							'http://schema.org/DesktopWebPlatform',
							'http://schema.org/IOSPlatform',
							'http://schema.org/AndroidPlatform'
						)
					),
					'result' => array(
						'@type' => 'Reservation',
						'name' => 'Contact Us'
					)
				);
			}

			if(count($data) > 0){
				foreach($data as $schema_key => $schema_value){
					$this->main[$schema_key] = $schema_value;
				}
			}
		}
		// Load Body Schema
		public function body_schema(){
			if($this->config->read('vendors/schema')){
				return ' itemscope itemtype="http://schema.org/WebPage"';
			}
			return '';
		}
		public function page_type_shema(){
			if($this->config->read('vendors/schema')){
	    		$cs_values = get_post_custom($this->post->get_post_id());
	    		$page_type = (isset($cs_values['page_type'])) ?  $cs_values['page_type'][0]  : "";

				// Article
	    		if($page_type == 'article'){
	    			return ' itemscope itemtype="http://schema.org/Article"';
	    		}
				// News Article
	    		if($page_type == 'news-article'){
	    			return ' itemscope itemtype="http://schema.org/NewsArticle"';
	    		}
	    		// FAQ Page
	    		if($page_type == 'faq'){
	    			return ' itemscope itemtype="http://schema.org/FAQPage"';
	    		}
				// QA Page
	    		if($page_type == 'qa'){
	    			return ' itemscope itemtype="http://schema.org/QAPage"';
	    		}
				// How To Guide
	    		if($page_type == 'how-to-guide'){
	    			return ' itemscope itemtype="http://schema.org/HowTo"';
	    		}
	    	}
    		return '';
		}
		public function get_main_entity_schema(){
			if($this->config->read('vendors/schema')){
	    		$cs_values = get_post_custom($this->post->get_post_id());
	    		$page_type = (isset($cs_values['page_type'])) ?  $cs_values['page_type'][0]  : "";

	    		$allow_page_types = array('qa');
	    		$schema_type = '';

	    		// QA Page
	    		if($page_type == 'qa'){
	    			$schema_type = ' itemtype="http://schema.org/Question"';
	    		}

	    		if(in_array($page_type, $allow_page_types)){
	    			return ' itemprop="mainEntity" itemscope' . $schema_type;
	    		}
	    	}
	    	return '';
		}
		public function after_body_schema(){
			if($this->config->read('vendors/schema')){
				$cs_values = get_post_custom($this->post->get_post_id());
	    		$page_type = (isset($cs_values['page_type'])) ?  $cs_values['page_type'][0]  : "";
    			$published_date = get_the_date('Y-m-d') . 'T' . get_the_date('H:i:s');

	    		$html = '<div class="hidden">';

	    		// Article & News Article
	    		if($page_type == 'article' || $page_type == 'news-article'){
	    			$html .= '<meta itemprop="image" content="'. $this->post->get_featured_image() .'">';
	    			$html .= '<div itemprop="publisher" itemscope itemtype="http://schema.org/Organization">';
	    			$html .= '<meta itemprop="name" content="'. $this->config->read('company/name') .'">';
	    			$html .= '<div itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">';
	    			$html .= '<img src="'. $this->config->read('company/logo') .'" alt="'. $this->config->read('company/name') .'" itemprop="url" />';
	    			$html .= '</div>';
	    			$html .= '</div>';
	    		}
	    		// QA Page
	    		if($page_type == 'qa'){

	    			$html .= '<span itemprop="dateCreated">'. $published_date .'</span>';
	    			$html .= '<div><span itemprop="answerCount">1</span> Answers</div>';
	    			$html .= '<div itemprop="author" itemscope itemtype="http://schema.org/Person">';
	    			$html .= '<meta itemprop="name" content="'. $this->config->read('company/name') .'">';
	    			$html .= '</div>';
	    		}

	    		$html .= '</div>';

	    		return $html;
	    	}
	    	return '';
		}
	}