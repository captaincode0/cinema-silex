<?php

	namespace CinemaSilex\Repository;

	use Silex\Application;

	abstract class Repository{
		protected $app;

		public function __construct(Application $app){
			$this->app = $app;
		}
	}