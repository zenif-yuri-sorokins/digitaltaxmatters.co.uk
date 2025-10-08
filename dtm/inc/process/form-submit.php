<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define('BASE_PATH', dirname(dirname(dirname(dirname(dirname(__DIR__))))));
	define('INC_DIR', dirname(__DIR__));

	define('WP_USE_THEMES', false);
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

	/* Load WP Theme Function */
	require_once BASE_PATH . '/wp-load.php');
	require_once INC_DIR . '/../functions.php';

	/* Load Configuration File  */
	require_once INC_DIR . '/config/site.php';

	header('Content-Type: application/json');

	$data = array(
		'valid' => 'no',
		'response' => 'There was an error submitting the form'
	);

	if(isset($_POST)){
		// Validation


		echo json_encode($data);
	}
	else{
		$data['response'] = 'The form was not submitted properly, please try again';

		echo json_encode($data);
	}