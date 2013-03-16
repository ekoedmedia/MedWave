<?php
/****************************\
 By: Jeremy Smereka
 ----------------------------
 classLoader
 Provides autoloading of 
 classes utilizing some
 very simplistic methods.
\****************************/

class autoloader {
	
	
	private $_namespace;
	private $_nsSeperator = '\\';
	

	public function __construct($namespace = null){
		$this->_namespace = $namespace;
	}
	
	public function registerLoader() {
		spl_autoload_register(array($this, 'autoLoadClass'));
	}
	
	public function unregisterLoader() {
		spl_autoload_unregister(array($this, 'autoLoadClass'));
	}
	
	public function autoLoadClass($classname) { 
		$class = strtolower($classname);
		$path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		$fileToInclude = $path.'.php';
		if (file_exists($fileToInclude)) {
			require $fileToInclude;
		} else {
			throw new \InvalidArgumentException("$classname is not a valid path.");
		}
	}
	
}