<?php

/*
 *
 *
 */

use MedWave\System\User\UserModel as UserModel;
use MedWave\System\ORM\Mapper as ORM;

namespace MedWave\System\User {

	class UserController {

		/**
		 * Returns TRUE or FALSE depending on 
		 * if authentication is successful based
		 * on variables passed into function.
		 *
		 * @var String : Username
		 * @var String : Password
		 * @return boolean
		 */
		public function authenticate($user_name, $password) {}

		/**
		 * Takes in User Object and persists to 
		 * database provided the data is pertinent to it.
		 *
		 * @var UserModel : UserObject
		 * @return String
		 */
		public function updateData(UserModel $user) {}

	}

}
