<?php
	function init(){
		/* Load Config and Router */
		$config = new Config($GLOBALS['config']);
		$router = new Router($config);

		/* Setup and Load App */
		$app = new App($config, $router);

		return array($app, $config);
	}