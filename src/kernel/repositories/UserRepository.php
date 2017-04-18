<?php

	namespace CinemaSilex\Repository;

	use CinemaSilex\Repository\Repository;
	use CinemaSilex\Entity\User;
	use CinemaSilex\Exception\UserNotFoundException;

	class UserRepository extends Repository{
		public function __construct($app){
			parent::__construct($app);
		}

		public function exists(User $user){
			
			$user_data = $this->app["db"]->fetchColumn("select id from users where email=? and passwd=?", [$user->getEmail(), $user->getPass()], 0);

			if(!$user_data)
				throw new UserNotFoundException($user->getEmail());

			return true;
		}
	}