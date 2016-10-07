<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class Download implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public function register() {
		Route::macro('download', function ($url, $file, $name = null,
			array $headers = [], $disposition = 'attachment') {
			return Route::any($url, Download::class . '@handle')
				->defaults('download', compact('file', 'name', 'headers', 'disposition'));
		});
	}

	/**
	 * Handle the redirect.
	 *
	 * @param  string  $destination
	 * @return \Illuminate\Http\RedirectResponse
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
		return $this->handle(
			$parameters['download']['file'],
			$parameters['download']['name'],
			$parameters['download']['headers'],
			$parameters['download']['disposition']
		);
	}
}
