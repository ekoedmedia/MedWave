<?php
namespace MedWave\System\ORM {

	class Mapper {

		/**
		 *
		 *
		 *
		 *
		 */
		public function __construct($table, Array $data)
		{	
			try {
				$determinedObj = $this->determineObj($table);
				$obj = new $determinedObj();
				foreach ($data AS $key => $value) {
					$obj->set$key($value);
				}

				return $obj;
			} catch (InvalidObjectException $e){
				##TODO: This probably isn't the correct function call for this.
				$e->get_error();
			}
		}


		/**
		 *
		 *
		 *
		 */
		private function determineObj($table) 
		{	
			$thisObject = null;
			##TODO: Add in SQL Show Tables from DBName
			$result = mysql_query('SHOW TABLE FROM DBNAME')
			foreach ($result AS $tableName) {
				if ($tableName == $table)
					$thisObject = $tableName;
			}

			if ($thisObject == null) {
				##TODO: Look into SPL Exceptions
				throw new InvalidObjectException(); 
			} else {
				return $thisObject;
			}
		}

	}

}



