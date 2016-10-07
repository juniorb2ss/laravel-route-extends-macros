<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class Redirect implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public static function register() {
		Route::macro('redirect', function ($url, $destination, $status = 301) {
			return Route::any($url, Redirect::class . '@handle')
				->defaults('redirection', compact('destination', 'status'));
		});
	}

	/**
	 * Handle the redirect.
	 *
	 * @param  string  $destination
	 * @param  int  $status
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function handle($destination, $status = 301) {
		return redirect($destination, $status);
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
			$parameters['redirection']['destination'],
			$parameters['redirection']['status']
		);
	}
}
