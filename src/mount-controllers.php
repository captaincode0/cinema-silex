<?php
	use CinemaSilex\Controller\PublicControllers;
	use CinemaSilex\Controller\PrivateControllers;
	use CinemaSilex\Controller\UserLoginControllers;
	use CinemaSilex\Repository\UserRepository;

	$app["repository.user"] = $app->share(function() use($app){
		return new UserRepository($app);
	});

	$app->mount("/", new PublicControllers());
	$app->mount("/private", new PrivateControllers());
	$app->mount("/auth", new UserLoginControllers());