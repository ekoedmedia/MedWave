<?php
/******************************\
 MedWave | Waves for the Future
 Version 1.0 - AlphaWave
 Written By: Jeremy Smereka
	     Amir Salimi
 ------------------------------
 core.medwave.php
 Provides autload functionality
 and determines which routes to
 use in the system when certain
 routes are being accessed.
\******************************/

use MedWave\System\ORM\Connector as Connector;

namespace MedWave\Core {

	class System {

        protected $dbcon;	

        public function __construct()
        {
            ##TODO: Add Autoload Registers Here

            // Parse YAML file to get Environment Settings
            $envir = yaml_parse_file('settings.yaml');
            if ($envir == false) {
                throw new \InvalidArgumentException("Settings.yaml does not exist or is unreadable.");
            } else {
                // Database connection begins
                $db_envir = $envir['database_env'];
                $db_string = Connector::create_connection_string($envir['type'],
                                                                 $envir['name'],
                                                                 $envir['user'],
                                                                 $envir['pass'],
                                                                 $envir['host'],
                                                                 $envir['port']);
                try { 
                    $this->dbcon = new Connector($db_string, $envir['user'], $envir['pass']);
                } catch (\PDOException $e) {
                    print $e->getMessage();
                }
                
            } 
        }
	
        ##TODO: Add Autoload Methods Here
        ##TODO: Add Routing Methods Here
        
        /**
         * Gets Database Connection
         * 
         * @return PDO Object
         */
        public function getDbcon()
        {
            return $this->dbcon;
        }	

    }

}
