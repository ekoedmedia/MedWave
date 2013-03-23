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
	private $systemBaseDir;

	public function __construct($namespace = null){
		$base_url = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
        $position = array_search('ekoed', $base_url);
        if ($position == 0) {
            throw new \RuntimeException("Ekoed folder should not be primary path");
        } else {
            $path = array_slice($base_url, 0, $position);
            $this->setSystemBaseDir(implode(DIRECTORY_SEPARATOR, $path));
        }
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
		if (file_exists($this->systemBaseDir.'/'.$fileToInclude)) {
			require $this->systemBaseDir.'/'.$fileToInclude;
		} else {
			throw new \InvalidArgumentException("$classname is not a valid path.");
		}
	}

	protected function setSystemBaseDir($systemBaseDir)
	{
		$this->systemBaseDir = $systemBaseDir;
	}
	
}
