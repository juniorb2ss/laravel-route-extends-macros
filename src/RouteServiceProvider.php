<?php

namespace Juniorb2ss\LaravelRouteExtendsMacros;

use Illuminate\Support\ServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
	/**
	 * list macros
	 * @var array
	 */
	protected $macros = [
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Redirect::class,
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Json::class,
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\View::class,
	];

	/**
	 * [register description]
	 * @return [type] [description]
	 */
	public function register() {
		foreach ($this->macros as $class) {
			$class::register();
		}
	}
}
