<?php

namespace Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase {
	public function getEnvironmentSetUp($app) {
		$app->make('Illuminate\Routing\Router')
			->middlewareGroup('abort403', [BasicMiddleware::class]);
	}
	protected function getPackageProviders($app) {
		return [\Juniorb2ss\LaravelRouteExtendsMacros\RouteServiceProvider::class];
	}
}
