<?php
namespace Juniorb2ss\LaravelRouteExtendsMacros\Macros;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Juniorb2ss\LaravelRouteExtendsMacros\Contracts\MacroInterface;

/**
 *
 */
class View implements MacroInterface {
	/**
	 * [register description]
	 * @return void
	 */
	public static function register() {
		Route::macro('view', function ($url, $view, $data = []) {
			return Route::any($url, View::class . '@handle')
				->defaults('view', compact('view', 'data'));
		});
	}

	/**
	 * Handle the redirect.
	 *
	 * @param  string  $destination
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function handle($view, $data) {
		return view($view, $data);
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
			$parameters['view']['view'],
			$parameters['view']['data']
		);
	}
}
