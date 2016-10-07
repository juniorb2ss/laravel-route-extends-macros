<?php
namespace Tests;
use Illuminate\Support\Facades\Route;

class ViewControllerTest extends TestCase {
	public function testViewRendered() {
		Route::view('/contact', 'contact');

		$this->get('/contact')
			->see('Contact us');
	}

	public function testViewWithDataRendered() {
		$data = [
			'name' => 'Test',
		];

		Route::view('/user', 'user', $data);

		$this->get('/user')
			->assertViewHasAll($data)
			->see('Test');
	}

	public function testViewAbort403() {
		Route::view('/user', 'user', [
			'name' => 'Test',
		])->middleware('abort403');

		$this->get('/user')
			->assertResponseStatus(403);
	}
}