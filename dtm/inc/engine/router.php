<?php
class Router{
	public $config;
	public $path;

	function __construct($config){
		$this->config = $config;
		$this->core_path();
	}
	private function core_path(){
		$this->path['inc'] = ROOT . $this->config->read('folder/inc') . '/';
		$this->path['admin'] = $this->path['inc'] . $this->config->read('folder/admin') . '/';
		$this->path['core'] = $this->path['inc'] . $this->config->read('folder/core') . '/';
		$this->path['engine'] = $this->path['inc'] . $this->config->read('folder/engine') . '/';
		$this->path['library'] = $this->path['inc'] . $this->config->read('folder/library') . '/';
		$this->path['template'] = $this->path['inc'] . $this->config->read('folder/template') . '/';
	}
}