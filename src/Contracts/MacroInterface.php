<?php

namespace Juniorb2ss\LaravelRouteExtendsMacros\Contracts;
use Illuminate\Routing\Router;

interface MacroInterface {
	public function register(Router $route);
}
