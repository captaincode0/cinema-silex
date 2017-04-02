<?php
	error_reporting(E_ALL);

	require_once __dir__."/../vendor/autoload.php";

	$app = require __dir__."/../src/app.php";

	require __dir__."/../src/mount-controllers.php";

	$app->run();