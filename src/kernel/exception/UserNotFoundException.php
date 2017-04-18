<?php 
	
	namespace CinemaSilex\Exception;

	class UserNotFoundException extends \LogicException{
		private $requested_email;

		public function __construct($requested_email){
			parent::__construct("El usuario con el email [$requested_email] no puede ser encontrado", 101, null);
			$this->requested_email = $requested_email;
		}

		public function getRequestedEmail(){
			return $this->requested_email;
		}
	}