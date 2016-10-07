<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class File implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register($route) {
		$route->macro('file', function ($url, $file, array $headers = []) use ($route) {
			return $route->any($url, File::class . '@handle')
				->defaults('file', compact('file', 'headers'));
		});
	}

	/**
	 * Handle the redirect.
	 *
	 * @param  string  $destination
	 * @return \Illuminate\Http\RedirectResponse
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
		return $this->handle(
			$parameters['file']['file'],
			$parameters['file']['headers']
		);
	}
}
