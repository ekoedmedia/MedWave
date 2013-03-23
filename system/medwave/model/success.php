<?php

/****************************\
 By: Jeremy Smereka
     Amir Salimi
 ----------------------------
 Success Model
 Provides a way of transporting
 success messages to and from
 forms and controllers
\****************************/

namespace MedWave\Model {

	class Success {

		protected $type;
		protected $message;

		public function __construct($type, $message)
		{
			$this->setType($type);
			$this->setMessage($message);
		}


		public function getType()
		{
			return $this->type;
		}

		public function setType($type)
		{
			$this->type = $type;
			return $this;
		}

		public function getMessage()
		{
			return $this->message;
		}

		public function setMessage($message)
		{
			$this->message = $message;
			return $this;
		}

	}

}
