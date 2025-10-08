<?php
	$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' . $_SERVER['SERVER_NAME'] . '/' : 'http://' . $_SERVER['SERVER_NAME'] . '/';

	$GLOBALS['config'] = array(
		'base_url' => $base_url,
		'dev_mode' => true,
		'lang' => 'en-GB',
		'company' => array(
			'name' => 'Digital Tax Matters',
			'telephone' => '01234 357 595',
			'email' => 'office@digitaltaxmatters.co.uk',
			'address' => array(
				'line_one' => '27 St Cuthbert\'s Street',
				'line_two' => '',
				'city' => 'Bedford',
				'country' => 'United Kingdom',
				'postcode' 	=> 'MK40 3JG',
				'link' => ''
			),
			'opt_out_email' => 'info@digitaltaxmatters.co.uk',
			'geo' => array(
				'lat' => '52.1386203',
				'long' => '-0.4651497'
			),
			'social_media' => array(
				'facebook' => 'https://www.facebook.com/digitaltaxmatters/',
				'twitter' => 'https://twitter.com/digitaltaxuk',
				'instagram' => 'https://www.instagram.com/digitaltaxmatters/',
				'linkedin' => 'https://www.linkedin.com/company/digital-tax-matters',
				'google-plus' => '',
				'youtube' => '',
				'pinterest' => ''
			),
			'logo' => get_template_directory_uri() . '/images/digital-tax-matters.png',
			'opening_times' => array(
				array(
					'days' => array(
						'Monday',
						'Tuesday',
						'Wednesday',
						'Thursday',
						'Friday'
					),
					'opens' => '9:00',
					'closes' => '17:30'
				),
				array(
					'days' => array(
						'Saturday',
						'Sunday'
					),
					'opens' => '9:00',
					'closes' => '13:30'
				)
			),
			'schema_image' => get_template_directory_uri() . '/images/digital-tax-matters.png',
			'rating' => array(
				'average' => '5',
				'count' => '33'
			),
			'what_they_do' => 'A WordPress Base Theme for Gud Ideas',
			'price_range' => 'N/A'
		),
		'currency' => array(
			'sign' => '£',
			'code' => 'GBP'
		),
		'admin' => array(
			'name' => 'Gud Ideas',
			'website' => 'http://www.gudideas.co.uk',
			'email' => 'websites@gudideas.co.uk',
			'copyright' => array(
				'false' => 'Web Design',
				'false' => 'Web Development',
			  	'false' => 'Website',
			  	'false' => 'SEO',
			  	'false' => 'Online Marketing',
			  	'true' 	=> 'Web Design, SEO',
			  	'false' => 'Website, Online Marketing',
			  	'false' => 'Web Design, Online Marketing',
			  	'false' => 'Website, SEO'
			)
		),
		'action' => array(
			'url' => $base_url . 'booking'
		),
		'post' => array(
			'exclude_categories' => array(3)
		),
		'meta' => array(
			'charset' => 'UTF-8',
			'viewport' => 'width=device-width, initial-scale=1.0, minimum-scale=1.0'
		),
		'vendors' => array(
			'schema' => true,
			'shortcode_section' => true,
			'seo_yoast' => true,
			'cf7' => true,
			'visual_composer' => false,
			'rev_slider' => false,
			'woocommerce' => false
		),
		'theme' => array(
			'layout' => 'full-width',
			'container_options' => array(
				'gi-container' => 'Contained Page',
				'gi-container-fluid' => 'Full Width Page'
			),
			'sidebar_col_size' => 4,
			'sidebar_options' => array(
				'no-sidebar' => 'No Sidebar',
				'sidebar-left' => 'Sidebar Left',
				'sidebar-right' => 'Sidebar Right'
			),
			'title_bar_options' => array(
				'background' => array(
					'bg-c-default' => 'Default Background Colour',
					'bg-c-primary' => 'Primary Background Colour',
					'bg-c-secondary' => 'Secondary Background Colour',
					'bg-c-grey' => 'Grey Background Colour',
					'bg-image' => 'Image Background',
					'bg-hidden' => 'Hidden'
				),
				'container' => array(
					'gi-container' => 'Contained',
					'gi-container-fluid' => 'Full Width'
				),
				'bg_overlay' => array(
					'x' => '0, 0, 0, 0.5',
					'y' => '0, 0, 0, 0.5'
				),
				'bg_position' => '50% 50%'
			),
			'page_types' => array(
				'faq' => 'FAQ Page',
				'qa' => 'QA Page',
				'how-to-guide' => 'How To Guide',
				'event' => 'Event',
				'job' => 'Job Posting',
				'recipe' => 'Recipe'
			),
			'scripts' => array(
				'jquery' => get_template_directory_uri() . '/js/jquery.js',
				'form' => get_template_directory_uri() . '/js/form.js',
				'wow' => get_template_directory_uri() . '/js/wow.js',
				'lazyload' => get_template_directory_uri() . '/js/lazyload.js',
				'paroller' => get_template_directory_uri() . '/js/paroller.js',
				'custom' => get_template_directory_uri() . '/js/custom.js'
			),
			'ie' => array(
				'scripts' => array(
					get_template_directory_uri() . '/js/html5.js',
					get_template_directory_uri() . '/js/respond.js'
				)
			),
			'styles' => array(
				'style' => get_stylesheet_uri()
			),
			'favicons' => array(
				'apple' => array(
					'57x57',
					'72x72',
					'76x76',
					'114x114',
					'120x120',
					'144x144',
					'152x152'
				),
				'ms' => array(
					'144x144'
				),
				'tile_colour' => '#FFFFFF'
			),
			'colour' => '#56A9FA'
		),
		'folder' => array(
			'inc' => 'inc',
			'admin' => 'admin',
			'core' => 'core',
			'engine' => 'engine',
			'library' => 'library',
			'template' => 'template'
		),
		'file_ext' => 'php',
		'pingback_url' => $base_url . 'xmlrpc.php'
	);