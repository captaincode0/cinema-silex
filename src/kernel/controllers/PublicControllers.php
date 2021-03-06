<?php

	namespace CinemaSilex\Controller;

	use Silex\Application;
	use Silex\ControllerProviderInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	class PublicControllers implements ControllerProviderInterface{
		/**
		 * @inerithdoc
		 */
		public function connect(Application $app){
			$controllers = $app["controllers_factory"];

			$controllers->get("/", function(){
				return "<h1>Home Page</h1>";
			});

			$controllers->get("/contact", function(){
				return "<h1>Contact Page</h1>";
			});

			$controllers->get("/login", function() use($app){
				return $app["twig"]->render("login.html.twig");
			});

			$controllers->after(function(Request $request, Response $response) use($app){
				$response->headers->set("content-type", "text/html");
			});

			return $controllers;
		}
	}