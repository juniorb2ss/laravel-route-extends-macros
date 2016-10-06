<?php

namespace Tests;

class BasicMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @return mixed
	 */
	public function handle() {
		abort(403);
	}
}
