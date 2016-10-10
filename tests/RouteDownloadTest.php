<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RouteDownloadTest extends TestCase {
	public function testDownloadFile() {
		$filePath = $this->fileForTesting();

		$this->route->download('/download', $filePath);

		$response = $this->get('/download')
			->seePageIs('/download')
			->seeFileInResponse($filePath, 'teste.ext');
	}

	public function testDownloadFileWithMiddleware() {
		$filePath = $this->fileForTesting();

		$this->route->download('/download', $filePath)
			->middleware('abort403');

		$response = $this->get('/download')
			->assertResponseStatus(403);
	}

	public function testDownloadFileWithCallback() {
		$filePath = $this->fileForTesting();

		$this->route->download('/download', function () use ($filePath) {
			return $filePath;
		});

		$response = $this->get('/download')
			->seePageIs('/download')
			->seeFileInResponse($filePath, 'teste.ext');
	}

	public function testDownloadFileWithCustomHeaders() {
		$filePath = $this->fileForTesting();

		$this->route->download('/download', $filePath, null, ['x-mod' => 'test']);

		$this->get('/download')
			->seePageIs('/download')
			->seeFileInResponse($filePath, 'teste.ext')
			->seeHeader('x-mod', 'test');
	}

	public function testDownloadFileWithCustomName() {
		$filePath = $this->fileForTesting();

		$this->route->download('/download', $filePath, 'users.json');

		$response = $this->get('/download')
			->seePageIs('/download')
			->seeFileInResponse($filePath, 'users.json');
	}

	protected function fileForTesting() {
		return __DIR__ . '/stubs/file/teste.ext';
	}

	protected function seeFileInResponse($filePath, $fileName) {
		$this->assertResponseOk();
		$this->assertInstanceOf(BinaryFileResponse::class, $this->response);
		$this->assertEquals($filePath, $this->response->getFile()->getRealPath());
		$this->assertEquals("attachment; filename=\"{$fileName}\"",
			$this->response->headers->get('content-disposition')
		);

		return $this;
	}
}
