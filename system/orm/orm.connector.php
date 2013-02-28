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

use MedWave\System\ORM\Mapper as Mapper;

namespace MedWave\System\ORM {
	
	class Connector extends PDO {
		
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
		
	}

}
