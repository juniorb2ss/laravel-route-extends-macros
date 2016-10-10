<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RouteDownloadTest extends TestCase {
	public function testDownloadFile() {
		$filePath = __DIR__ . '/stubs/file/teste.ext';

		$this->route->download('/download', $filePath);

		$response = $this->get('/download')
			->seePageIs('/download')
			->assertResponseOk();

		$this->assertInstanceOf(BinaryFileResponse::class, $response->response);
		$this->assertEquals($filePath, $response->response->getFile()->getRealPath());
		$this->assertEquals('attachment; filename="teste.ext"',
			$response->response->headers->get('content-disposition')
		);
	}

	public function testDownloadFileWithMiddleware() {
		$filePath = __DIR__ . '/stubs/file/teste.ext';

		$this->route->download('/download', $filePath)
			->middleware('abort403');

		$response = $this->get('/download')
			->assertResponseStatus(403);
	}

	public function testDownloadFileWithCallback() {
		$filePath = __DIR__ . '/stubs/file/teste.ext';

		$this->route->download('/download', function () use ($filePath) {
			return $filePath;
		});

		$response = $this->get('/download')
			->seePageIs('/download')
			->assertResponseOk();

		$this->assertInstanceOf(BinaryFileResponse::class, $response->response);
		$this->assertEquals($filePath, $response->response->getFile()->getRealPath());
		$this->assertEquals('attachment; filename="teste.ext"',
			$response->response->headers->get('content-disposition')
		);
	}

	public function testDownloadFileWithCustomHeaders() {
		$filePath = __DIR__ . '/stubs/file/teste.ext';

		$this->route->download('/download', $filePath, null, ['x-mod' => 'teste']);

		$response = $this->get('/download')
			->seePageIs('/download')
			->assertResponseOk();

		$this->assertInstanceOf(BinaryFileResponse::class, $response->response);
		$this->assertEquals($filePath, $response->response->getFile()->getRealPath());
		$this->assertEquals('attachment; filename="teste.ext"',
			$response->response->headers->get('content-disposition')
		);

		$this->assertEquals('teste',
			$response->response->headers->get('x-mod')
		);
	}

	public function testDownloadFileWithCustomName() {
		$filePath = __DIR__ . '/stubs/file/teste.ext';

		$this->route->download('/download', $filePath, 'users.json');

		$response = $this->get('/download')
			->seePageIs('/download')
			->assertResponseOk();

		$this->assertInstanceOf(BinaryFileResponse::class, $response->response);
		$this->assertEquals($filePath, $response->response->getFile()->getRealPath());
		$this->assertEquals('attachment; filename="users.json"',
			$response->response->headers->get('content-disposition')
		);
	}
}
