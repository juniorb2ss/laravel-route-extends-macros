<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class File implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register(Router $route) {
		$route->macro('file', function ($url, $file, array $headers = []) use ($route) {
			return $route->any($url, '\Juniorb2ss\LaravelRouteExtendsMacros\Macros\File@handle')
				->defaults('file', compact('file', 'headers'));
		});
	}

	/**
	 * Return the raw contents of a binary file.
	 *
	 * @param  \SplFileInfo|string  $file
	 * @param  array  $headers
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function handle($file, array $headers = []) {
		$file = (is_callable($file) ? $file() : $file);
		return response()->file($file, $headers);
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
		return call_user_func_array([$this, $method], $parameters['file']);
	}
}
