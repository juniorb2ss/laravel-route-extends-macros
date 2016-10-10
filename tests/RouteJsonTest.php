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

	public function testResponseJsonWithCustomStatus() {
		$data = ['key' => 'value'];

		$this->route->json('/json', $data, 301);

		$this->get('/json')
			->assertResponseStatus(301);
	}

	public function testResponseJsonWithCustomHeaders() {
		$data = ['key' => 'value'];

		$this->route->json('/json', $data, 200, ['x-mod' => 'test']);

		$this->get('/json')
			->assertResponseStatus(200)
			->seeHeader('x-mod');
	}

	public function testResponseJsonWithMiddleware() {
		$data = collect(['key' => 'value']);

		$this->route->json('/json', $data)
			->middleware('abort403');

		$this->get('/json')
			->assertResponseStatus(403);
	}
}
