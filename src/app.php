<?php
	
	use Silex\Application;
	use Silex\Provider\DoctrineServiceProvider;
	use Silex\Provider\MonologServiceProvider;
	use Silex\Provider\ValidatorServiceProvider;
	use Silex\Provider\UrlGeneratorServiceProvider;

	$app = new Application();
	
	return $app;
