<?php

namespace Tests;

use Illuminate\Support\Facades\Route;

class RouteFileTest extends TestCase {
	public function testFileSeeContent() {
		$filePath = __DIR__ . '/stubs/file/file.txt';

		$this->route->file('/file', $filePath);

		$response = $this->get('/file')
			->seePageIs('/file')
			->assertResponseOk();
	}

	public function testFileSeeContentWithCallbackFileName() {
		$filePath = __DIR__ . '/stubs/file/file.txt';

		$this->route->file('/file', function () use ($filePath) {
			return $filePath;
		});

		$response = $this->get('/file')
			->seePageIs('/file')
			->assertResponseOk();
	}

	public function testFileSeeContentWithMiddleware() {
		$filePath = __DIR__ . '/stubs/file/file.txt';

		$this->route->file('/file', $filePath)
			->middleware('abort403');

		$response = $this->get('/file')
			->assertResponseStatus(403);
	}
}
