<?php

	namespace CinemaSilex\Controller;

	use Silex\Application;
	use Silex\ControllerProviderInterface;
	use CinemaSilex\Entity\User;
	use Symfony\Component\HttpFoundation\Request;
	use CinemaSilex\Exception\UserNotFoundException;

	class UserLoginControllers implements ControllerProviderInterface{
		public function connect(Application $app){
			$controllers = $app["controllers_factory"];

			$controllers->post("/login", function(Request $request) use($app){
				try{
					$user = new User();
					$user->setEmail($request->get("email"));
					$user->setPass($request->get("pass"));	

					if($app["repository.user"]->exists($user)){
						$app["session"]->set("user", $user);
						return "<h1>Iniciaste sesión chido!!!</h1>";
					}			
				}
				catch(UserNotFoundException $ex){
					return $ex->getMessage();
				}
			})
				->before(function(Request $request) use($app){
					$user = new User();
					$user->setEmail($request->get("email"));
					$user->setPass($request->get("pass"));

					$errors = $app["validator"]->validate($user);

					if(!empty($errors)){
						$message = "";
						foreach($errors as $error){
							$message .= $errors->getMessage()."<br>";
						}

						return $message;
					}
				})
				->bind("middleware.auth.login");

			$controllers->get("/logout", function(){

			})
				->bind("middleware.auth.logout");



			return $controllers;
		}
	}