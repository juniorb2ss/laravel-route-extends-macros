<?php

namespace Tests;

use Illuminate\Support\Facades\Route;

class RouteJsonTest extends TestCase {
	public function testResponseJsonWithCollection() {
		$data = collect(['key' => 'value']);

		$this->route->json('/json', $data);

		$this->get('/json')
			->assertResponseStatus(200)
			->seePageIs('/json')
			->seeJsonEquals([
				'key' => 'value',
			]);
	}

	public function testResponseJsonWithArray() {
		$data = ['key' => 'value'];

		$this->route->json('/json', $data);

		$this->get('/json')
			->assertResponseStatus(200)
			->seePageIs('/json')
			->seeJsonEquals([
				'key' => 'value',
			]);
	}

	public function testResponseJsonWithMiddleware() {
		$data = collect(['key' => 'value']);

		$this->route->json('/json', $data)
			->middleware('abort403');

		$this->get('/json')
			->assertResponseStatus(403);
	}
}
