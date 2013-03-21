<?php

/****************************\
 Ekoed Core
 Written By: Jeremy Smereka
 Version 1.0
 ----------------------------
 Core
 Provides basic functionality
 such as connecting with PDO
 to the SQLite Database and
 setting up of basic 
 data types.
\****************************/

namespace Ekoed\Core {

    class System {

        protected $baseDir;
        protected $systemBaseDir;
        protected $dbHandle;

        /**
         * Constructs Core and sets a Database handler
         *
         * @var String $baseDir 
         * @var String $systemBaseDir
         */
        public function __construct($baseDir, $systemBaseDir)
        {
            $this->setBaseDir($baseDir);
            $this->setSystemBaseDir($systemBaseDir);
        }

        /**
         * Determines route based on current supplied SERVER URI
         *
         * @var String route
         * @return View from HTML
         */
        public function determineRoute($route)
        {   
            $route = ltrim($route, '\/'); // Remove first /
            $controller = explode('?c=', $route, 2); // Determines if Route is a Controller
            if (count($controller) > 1) {
                // Seperate the destination from the controller
                $selectedControllers = explode('&d=', $controller[1]);
                $controller = $selectedControllers[0];
                $destination = $selectedControllers[1];
                try {
                    $this->loadController($controller, $destination);
                } catch (\RuntimeException $e) {
                    error_log($e);
                }
            } else {
                // Since Route is not a controller, attempt to load view
                $base_url = explode(DIRECTORY_SEPARATOR, $route, 2);
                $inArray = array_search($this->getBaseDir(), $base_url);
                if ($inArray !== false)
                    unset($base_url[$inArray]);
                $base_url = array_values($base_url);
                // Sends index.php view if no path
                if ($base_url[0] == ""){
                    return $this->getSystemBaseDir().'/view/index.php';
                // Sends view based on base_url[0]
                } elseif (file_exists('ucs/view/'.$base_url[0].'.php') && $base_url[0] != ""){
                    return $this->getSystemBaseDir().'/view/'.$base_url[0].'.php';
                // Sends 404 view otherwise.
                } else {
                    return $this->getSystemBaseDir().'/view/404.php';
                }
            }
        }

        /**
         * Loads a controller and process its correctly
         * 
         * @var String controller
         * @var String route to return to
         */
        protected function loadController($controller, $destination)
        {
            $controller = 'UCS\Controller\\'.$controller; // Create Namespace for Class
            if (!isset($_POST['CMD'])){
                throw new \RuntimeException("Controller was not able to execute, due to missing Command Token.");
            }
            try {
                $c = new $controller($_POST['CMD'], $destination, $this->dbHandle);
            } catch (\InvalidArgumentException $e){
                return $this->getSystemBaseDir().'/view/404.php';
                error_log($e);
            }
        }

        /****************************\
         Start of Getters and Setters
        \****************************/

        /**
         * Sets base directory for use in Router
         *
         * @var String Base Directory
         * @return this
         */
        public function setBaseDir($baseDir)
        {
            $this->baseDir = $baseDir;
            return $this;
        }

        /**
         * Gets base directory for use in Router
         * @return Base Directory
         */
        public function getBaseDir()
        {
            return $this->baseDir;
        }

        /** 
         * Gets System Base Directory
         *
         * @return System Base Directory
         */
        public function getSystemBaseDir()
        {
            return $this->systemBaseDir;
        }

        /**
         * Sets System Base Directory
         *
         * @var System Base Directory
         * @return this
         */
        public function setSystemBaseDir($systemBaseDir)
        {
            $this->systemBaseDir = $systemBaseDir;
            return $this;
        }

        /**
         * Sets Database Handle
         *
         * @var Object Database Handle
         * @return this
         */
        public function setDbHandle($dbHandle)
        {
            $this->dbHandle = $dbHandle;
            return $this;
        }

        /**
         * Get Database Handle
         * @return Database Handle
         */
        public function getDbHandle()
        {
            return $this->dbHandle;
        }


    }

}
