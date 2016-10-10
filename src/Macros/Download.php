<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class Download implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register(Router $route) {
		$route->macro('download', function ($url, $file, $name = null,
			array $headers = [], $disposition = 'attachment') use ($route) {
			return $route->any($url, '\Juniorb2ss\LaravelRouteExtendsMacros\Macros\Download@handle')
				->defaults('download', compact('file', 'name', 'headers', 'disposition'));
		});
	}

	/**
	 * Create a new file download response.
	 *
	 * @param  \SplFileInfo|string  $file
	 * @param  string  $name
	 * @param  array  $headers
	 * @param  string|null  $disposition
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function handle($file, $name = null,
		array $headers = [], $disposition = 'attachment') {
		$file = (is_callable($file)) ? $file() : $file;
		return response()->download($file, $name, $headers, $disposition);
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
		return call_user_func_array([$this, $method], $parameters['download']);
	}
}
