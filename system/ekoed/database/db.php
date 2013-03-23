<?php
/******************************\
 Ekoed Database
 Written By: Jeremy Smereka
 Version 1.0
 ------------------------------
 Database
 Provides an overall abstration
 layer to the Database. This 
 uses PDO at the base layer. 
\******************************/

namespace Ekoed\Database {

    use MedWave\ORM as ORM;    

    class DB {
        
        protected $dbcon;

        public function __construct()
        {
            $fileContents = file_get_contents("system/settings.json");
            $envir = json_decode($fileContents);
            if ($envir == false) {
                throw new \InvalidArgumentException("system/settings.json does not exist or is uneadable.");
            } else {    
                $db_envir = $envir->database_env;
                foreach ($db_envir AS $envir) {
                    $db_string = ORM\Connector::create_connection_string($envir->type,
                                                                         $envir->name,
                                                                         $envir->pass,
                                                                         $envir->host,
                                                                         $envir->port);
                    try {
                        $this->dbcon[$envir->name] = new ORM\Connector($db_string, $envir->user, $envir->pass);
                    } catch (\PDOException $e) {
                        print $e->getMessage();
                    }
                }
            }       
        }
        
        /**
         * Gets Database Connection
         *
         * @return PDO dbcon
         */
        public function getDbcon($name = null)
        {
            if ($name)
                return $this->dbcon[$name];
            else 
                return $this->dbcon;
        }

    }
    
}
