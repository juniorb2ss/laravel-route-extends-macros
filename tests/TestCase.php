<?php

namespace Tests;
use Juniorb2ss\LaravelRouteExtendsMacros\RouteServiceProvider as ServicePackage;

abstract class TestCase extends \Orchestra\Testbench\TestCase {
	protected $route;

	public function getEnvironmentSetUp($app) {
		$this->route = $app['router'];

		$this->route->middlewareGroup('abort403', [
			BasicMiddleware::class,
		]);
	}

	protected function getPackageProviders($app) {
		$app['config']->set('view.paths', [__DIR__ . '/stubs/views']);

		return [
			ServicePackage::class,
		];
	}
}
