<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class Json implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register($route) {
		$route->macro('json', function ($url, $structure) use ($route) {
			return $route->any($url, Json::class . '@handle')
				->defaults('json', compact('structure'));
		});
	}

	/**
	 * Handle the redirect.
	 *
	 * @param  string  $destination
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function handle($structure) {
		return response()->json($structure);
	}

	/**
	 * Extract the redirect data from the route and call the handler.
	 *
	 * @param  string  $method
	 * @param  array  $parameters
	 * @return \Illuminate\Http\RedirectResponse
	 * @SuppressWarnings("unused")
	 */
	public function callAction($method, $parameters) {
		return $this->handle(
			$parameters['json']['structure']
		);
	}
}
