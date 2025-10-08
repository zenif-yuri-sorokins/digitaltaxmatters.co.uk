<?php
	class App{
		public $config;
		public $router;

		function __construct($config = '', $router = ''){
			$this->config = $config;
			$this->router = $router;
		}
		public function loader($class, $extends = true, $params = array()){
			$this->check_file($class);

			if(class_exists($class) && $extends == true){
				$class = new ReflectionClass($class);
				
				$instant = $class->newInstanceArgs(array($this->config, $this->router));
				
				if($class->hasMethod('_construct')){
					$instant->_construct();
				}
				return $instant;
			}
		}
		private function check_file($class){
			$file_name = strtolower($class) . '.' . $this->config->read('file_ext');

			// Check if file in admin folder exists
			if(file_exists($this->router->path['admin'] . $file_name)){
				$this->load($this->router->path['admin'] . $file_name);
			}
			// Check if file in core folder exists
			elseif(file_exists($this->router->path['core'] . $file_name)){
				$this->load($this->router->path['core'] . $file_name);
			}
			// Check if file in engine folder exists
			elseif(file_exists($this->router->path['engine'] . $file_name)){
				$this->load($this->router->path['engine'] . $file_name);
			}
			// Check if file in library folder exists
			elseif(file_exists($this->router->path['library'] . $file_name)){
				$this->load($this->router->path['library'] . $file_name);
			}
			// Check if file in Templates folder exists
			elseif(file_exists($this->router->path['template'] . $file_name)){
				$this->load($this->router->path['template'] . $file_name);
			}
			else{
				echo $file_name . ' file does not exist';
				exit();
			}
		}
		private function load($file){
			require_once $file;
		}
	}
