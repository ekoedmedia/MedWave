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
        public function __construct($baseDir)
        {
            // Sets Base Directory
            $this->setBaseDir($baseDir);

            // Figures out System Directory
            $base_url = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
            $position = array_search('ekoed', $base_url);
            if ($position == 0) {
                throw new \RuntimeException("Ekoed folder should not be primary path");
            } else {
                $path = array_slice($base_url, 0, $position);
                $this->setSystemBaseDir(implode(DIRECTORY_SEPARATOR, $path));
            }
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
                    print $e->getMessage();
                    error_log($e);
                }
            } else {
                // Since Route is not a controller, attempt to load view
                $base_url = explode(DIRECTORY_SEPARATOR, $route, 2);
                var_dump($base_url);
                $inArray = array_search($this->getBaseDir(), $base_url);
                if ($inArray !== false) {
                    unset($base_url[$inArray]);
                    $base_url = array_values($base_url);
                }
                // Sends index.php view if no path
                if ($base_url[0] == ""){
                    return $this->getSystemBaseDir().'/medwave/views/index.php';
                // Sends view based on base_url[0]
                } elseif (file_exists($this->getSystemBaseDir().'/medwave/views/'.$base_url[0].'.php') && $base_url[0] != ""){
                    return $this->getSystemBaseDir().'/medwave/views/'.$base_url[0].'.php';
                // Sends 404 view otherwise.
                } else {
                    return $this->getSystemBaseDir().'/medwave/views/404.php';
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
         * Gets Base Directory
         * 
         * @return Base Directory
         */
        protected function getBaseDir()
        {
            return $this->baseDir;
        }

        /**
         * Sets Base Directory
         * 
         * @var string Base Directory
         * @return Base Directory
         */
        protected function setBaseDir($baseDir)
        {
            $this->baseDir = $baseDir;
            return $this;
        }

        /** 
         * Gets System Base Directory
         *
         * @return System Base Directory
         */
        protected function getSystemBaseDir()
        {
            return $this->systemBaseDir;
        }

        /**
         * Sets System Base Directory
         *
         * @var System Base Directory
         * @return this
         */
        protected function setSystemBaseDir($systemBaseDir)
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
