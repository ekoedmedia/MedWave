<?php

/*
 *
 *
 *
 */

namespace MedWave\User {

	class UserModel {

		protected $user_name;
		protected $password;
		protected $class;
		protected $date_registered;

		public function getUser_name() 
		{ 
			return $this->user_name; 
		}
		

		public function setUser_name($user_name) 
		{ 	
			$this->user_name = $user_name; 
			return $this; 
		}
		

		public function getPassword() 
		{ 
			return $this->password; 
		}
		

		public function setPassword($password) 
		{ 
			$this->password = $password; 
			return $this; 
		}
		

		public function getClass() 
		{ 
			return $this->class; 
		}
		

		public function setClass($class) 
		{ 
			$this->class = $class; 
			return $this; 
		}
		

		public function getDate_registered() 
		{ 
			return $this->date_registered; 
		}
		

		public function setDate_registered($date_registered) 
		{ 
			$this->date_registered = $date_registered; 
			return $this; 
		}

	}

}
