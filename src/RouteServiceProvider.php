<?php

namespace Juniorb2ss\LaravelRouteExtendsMacros;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider {
	/**
	 * list macros
	 * @var array
	 */
	protected $macros = [
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Redirect::class,
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Json::class,
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\View::class,
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Download::class,
		\Juniorb2ss\LaravelRouteExtendsMacros\Macros\File::class,
	];

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot() {
		//

		parent::boot();
	}

	/**
	 * [register description]
	 * @return [type] [description]
	 */
	public function map(Router $route) {
		foreach ($this->macros as $class) {
			(new $class)->register($route);
		}
	}
}
