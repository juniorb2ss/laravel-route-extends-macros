<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class View implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register(Router $route) {
		$route->macro('view', function($url, $view, $data = [], array $mergeData = []) use ($route) {
			return $route->any($url, '\Juniorb2ss\LaravelRouteExtendsMacros\Macros\View@handle')
				->defaults('view', compact('view', 'data', 'mergeData'));
		});
	}

	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @param  array   $mergeData
	 * @return \Illuminate\Contracts\View\View
	 */
	public function handle($view, $data, array $mergeData = []) {
		return view($view, $data, $mergeData);
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
		return call_user_func_array([$this, $method], $parameters['view']);
	}
}
