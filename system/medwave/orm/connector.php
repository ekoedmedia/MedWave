<?php
/******************************\
 MedWave | Waves for the Future
 Version 1.0 - AlphaWave
 Written by: Jeremy Smereka
	     Amir Salimi
 ------------------------------
 orm.connector.php
 Provides database connection,
 query. Extends the PDO class.
\******************************/

namespace MedWave\ORM {
	
	class Connector extends \PDO {
		
		/**
		 * Calls parent constructor with same parameters
		 *
		 * @var String $dsn : Connection String
		 * @var String $user : Username
		 * @var String $pass : Password
		 * @var Array $opts : Connection Options
		 */
		public function __construct($dsn, 
					    $user = null, 
					    $pass = null, 
					    $opts = null)
		{
		    parent::__construct($dsn, $user, $pass, $opts);
		}

        /**
         * Determines and returns database connection string
         *
         * @var String $type : Connection Type
         * @var String $dbname : DB Name
         * @var String $user : Username
         * @var String $pass : Password
         * @var String $host : Host
         * @var int $port : Port Number
         *
         * @return String : Database Connection String for PDO
         */
        public static function create_connection_string($type, 
                                                        $dbname, 
                                                        $user, 
                                                        $pass, 
                                                        $host = 'localhost', 
                                                        $port = null)
        {
            $db_string = null;

            switch ($type) {
                case "mysql":
                    $sPort = (!is_null($port)? "port=".$port.";" : "");
                    $sHost = "host=".$host.";";
                    $sDbname = "dbname=".$dbname;
                    $db_string = "mysql:".$sHost.$sPort.$sDbname;
                    break;
                default:
                    throw new \InvalidArgumentException("Database of Type ".$type." is not valid type.");
                    break;
            }

            return $db_string;
        }

		
	}

}
