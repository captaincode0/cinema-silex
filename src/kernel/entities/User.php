<?php
	
	namespace CinemaSilex\Entity;

	use CinemaSilex\Entity\EntityInterface;
	use Symfony\Component\Validator\Constraints as Assert;
	use Symfony\Component\Validator\Mapping\ClassMetadata;

	class User implements EntityInterface{
		private $id;
		private $email;
		private $pass;

		public function __construct(){
			$this->id = 0;
			$this->email = "";
			$this->pass = "";
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getPass(){
			return $this->pass;
		}

		public function setPass($pass){
			$this->pass = $pass;
		}

		public function cyphPass(){
			$this->pass = md5($this->pass);
		}

		public static function loadClassValidator(ClassMetadata $metadata){
			$metadata->addPropertyConstraint("id", new Assert\Regex([
				"pattern" => "/\d+/",
				"message" => "El identificador debe ser numérico"
			]));

			$metadata->addPropertyConstraint("email", new Assert\Email([
				"checkMX" => false
			]));

			$metadata->addPropertyConstraint("pass", new Assert\Regex([
				"pattern" => "/[a-zA-Z_0-9]+/",
				"message" => "La contraseña del usuario no es válida"
			]));
		}
	}