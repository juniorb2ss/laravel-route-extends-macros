<?php

namespace Tests;

use Illuminate\Support\Facades\Route;

class RedirectTest extends TestCase {
	public function testRedirectUses301StatusByDefault() {
		Route::redirect('/contact_us', 'contact');
		Route::get('/contact', function () {});

		$this->get('/contact_us')
			->assertResponseStatus(301)
			->followRedirects()
			->seePageIs('/contact');
	}

	public function testCanOverrideDefaultRedirectStatus() {
		Route::redirect('/contact_us', 'contact', 302);
		Route::get('/contact', function () {});

		$this->get('/contact_us')
			->assertResponseStatus(302)
			->followRedirects()
			->seePageIs('/contact');
	}

	public function testRedirectUses403StatusWithMiddleware() {
		Route::redirect('/contact_us', 'contact')
			->middleware('abort403');

		Route::get('/contact', function () {});

		$this->get('/contact_us')
			->assertResponseStatus(403);
	}
}
