<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\JsonResponse;
	
	$app["myapp.parameter"] = "ofisofjsfdasd";

	//método get simple
	$app->get("/", function() use($app){
		return "<h1>Hello world</h1>".$app["myapp.parameter"];
	});

	//método get con parámetros
	$app->get("/test/{value}", function($value) use($app){
		return "<h1>$value</h1>";
	})
		->convert("value", function($v){
			return strtolower($v);
		});

	//método get con parámetros usando el objeto request
	$app->get("/testb/view", function(Request $request) use($app){
		$view_name = $request->get("s");
		return "<h1>$view_name</h1>";
	});

	//usando un método post
	$app->post("/post/submit", function(Request $request) use($app){
		$title = $request->get("title");
		$content = $request->get("content");

		return new JsonResponse(["title" => $title, "content" => $content], 201);
	});
