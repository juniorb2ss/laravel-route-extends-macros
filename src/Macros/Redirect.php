<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class Redirect implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register(Router $route) {
		$route->macro('redirect', function ($url, $to, $status = 302,
			array $headers = [], $secure = null) use ($route) {
			return $route->any($url, '\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Redirect@handle')
				->defaults('redirection', compact('to', 'status', 'headers', 'secure'));
		});
	}

	/**
	 * Get an instance of the redirector.
	 *
	 * @param  string|null  $to
	 * @param  int     $status
	 * @param  array   $headers
	 * @param  bool    $secure
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function handle($to = null, $status = 302, $headers = [], $secure = null) {
		return redirect($to, $status, $headers, $secure);
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
		return call_user_func_array([$this, $method], $parameters['redirection']);
	}
}
