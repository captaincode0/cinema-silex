<?php
	namespace CinemaSilex\Controller;

	use Silex\Application;
	use Silex\ControllerProviderInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	class PrivateControllers implements ControllerProviderInterface{
		public function connect(Application $app){
			$controllers = $app["controllers_factory"];

			$controllers->get("/", function() use($app){
				return "<h1>This is a private zone</h1>";
			});

			$controllers->get("/profile", function(Request $request) use($app){
				$session = $request->getSession();
				$email = "";

				if($session){
					$session->start();
					$email = $session->get("user")->getEmail();
				}
				return "<h1>User profile: $email</h1>";
			});

			$controllers->after(function(Request $request, Response $response) use($app){
				$response->headers->set("content-type", "text/html");
			});

			return $controllers;
		}
	}