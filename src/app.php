<?php
	
	use Silex\Application;
	use Silex\Provider\DoctrineServiceProvider;
	use Silex\Provider\MonologServiceProvider;
	use Silex\Provider\ValidatorServiceProvider;
	use Silex\Provider\UrlGeneratorServiceProvider;
	use Silex\Provider\SessionServiceProvider;
	use Silex\Provider\TwigServiceProvider;

	$app = new Application();

	$app["debug"] = true;
	$app->register(new UrlGeneratorServiceProvider());
	$app->register(new ValidatorServiceProvider());
	$app->register(new SessionServiceProvider());
	$app->register(new DoctrineServiceProvider(), [
		"db.options" => [
			"user" => "root",
			"password" => "data.set",
			"driver" => "pdo_mysql",
			"host" => "localhost",
			"dbname" => "cinemadb", 
			"port" => "3306"
		]
	]);
	
	$app->register(new TwigServiceProvider(), [
		"twig.path" => __dir__."/../views/"
	]);

	return $app;
