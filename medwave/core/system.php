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

namespace MedWave\Core {

	use \MedWave\System\ORM as ORM;

	class System {

        protected $dbcon;	

        public function __construct()
        {
            ##TODO: Add Autoload Registers Here

            // Parse YAML file to get Environment Settings
<<<<<<< HEAD
 	    $fileContents = file_get_contents(dirname(__FILE__)."/settings.json");
            $envir = json_decode($fileContents);
=======
            $envir = json_decode(dirname(__FILE__).'/settings.json');
>>>>>>> 8d7c41ad7127e58a213bbf8394f172bd624ade16
            if ($envir == false) {
                throw new \InvalidArgumentException(dirname(__FILE__)."/settings.json does not exist or is unreadable.");
            } else {
                // Database connection begins
		##TODO: Make this a foreach loop which creates connection for each DB_Envir defined.
                $db_envir = $envir->database_env;
                $db_string = ORM\Connector::create_connection_string($db_envir[0]->type,
                                                                 $db_envir[0]->name,
                                                                 $db_envir[0]->user,
                                                                 $db_envir[0]->pass,
                                                                 $db_envir[0]->host,
                                                                 $db_envir[0]->port);
                try { 
                    $this->dbcon = new ORM\Connector($db_string, $db_envir[0]->user, $db_envir[0]->pass);
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
