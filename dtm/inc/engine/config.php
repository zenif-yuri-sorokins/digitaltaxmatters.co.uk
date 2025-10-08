<?php
	class Config{
		protected $config = array();

		function __construct($attr = array()){
			$this->config = $attr;
		}
		public function read($paths = null){
			if($paths){
				$paths = explode('/', $paths);
				$value = $this->config;

				foreach($paths as $path){
					if(isset($value[$path])){
						$value = $value[$path];
					}
				}
				if(!empty($value)){
					return $value;
				}
			}
			return false;
		}
	}
