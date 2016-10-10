<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class Json implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register(Router $route) {
		$route->macro('json', function ($url, $data, $status = 200,
			array $headers = [], $options = 0) use ($route) {
			return $route->any($url, Json::class . '@handle')
				->defaults('json', compact('data', 'status', 'headers', 'options'));
		});
	}

	/**
	 * Return a new JSON response from the application.
	 *
	 * @param  mixed  $data
	 * @param  int  $status
	 * @param  array  $headers
	 * @param  int  $options
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function handle($data = [], $status = 200, array $headers = [], $options = 0) {
		return response()->json($data, $status, $headers, $options);
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
		return call_user_func_array([$this, $method], $parameters['json']);
	}
}
