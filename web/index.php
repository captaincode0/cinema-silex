<?php
	error_reporting(E_ALL);

	define("ROOT_DIR", __dir__."/../");

	require_once ROOT_DIR."vendor/autoload.php";

	$app = require ROOT_DIR."src/app.php";

	require ROOT_DIR."src/kernel/entities/EntityLoader.php";
	require ROOT_DIR."src/kernel/controllers/ControllerLoader.php";
	require ROOT_DIR."src/kernel/exception/ExceptionLoader.php";
	require ROOT_DIR."src/kernel/repositories/RepositoryLoader.php";
	require ROOT_DIR."src/mount-controllers.php";

	$app->run();