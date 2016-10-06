<?php

namespace Tests;

use Illuminate\Support\Facades\Route;

class RouteJsonTest extends TestCase {
	public function testResponseJsonWithCollection() {
		$date = collect(['key' => 'value']);

		Route::json('/json', $date);

		$this->get('/json')
			->assertResponseStatus(200)
			->seePageIs('/json')
			->seeJsonEquals([
				'key' => 'value',
			]);
	}

	public function testResponseJsonWithArray() {
		$date = ['key' => 'value'];

		Route::json('/json', $date);

		$this->get('/json')
			->assertResponseStatus(200)
			->seePageIs('/json')
			->seeJsonEquals([
				'key' => 'value',
			]);
	}

	public function testResponseJsonWithMiddleware() {
		$date = collect(['key' => 'value']);

		Route::json('/json', $date)
			->middleware('abort403');

		$this->get('/json')
			->assertResponseStatus(403);
	}
}
