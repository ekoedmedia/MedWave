<?php

/****************************\
 By: Jeremy Smereka
     Amir Salimi
 ----------------------------
 Error Model
 Provides a way of transporting
 error messages to and from
 forms and controllers
\****************************/

namespace MedWave\Model {

	class Error {

		protected $type;
		protected $message;
		protected $code;

		public function __construct($type, $code, $message)
		{
			$this->setType($type);
			$this->setCode($code);
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

		public function getCode()
		{
			return $this->code;
		}

		public function setCode($code)
		{
			$this->code = $code;
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
