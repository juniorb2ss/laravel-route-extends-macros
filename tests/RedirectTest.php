<?php

namespace Tests;

class RedirectTest extends TestCase {
	public function testRedirectUses301StatusByDefault() {
		$this->route->redirect('/contact_us', 'contact');

		$this->get('/contact_us')
			->assertResponseStatus(302)
			->assertRedirectedTo('/contact');
	}

	public function testCanOverrideDefaultRedirectStatus() {
		$this->route->redirect('/contact_us', 'contact', 301);

		$this->get('/contact_us')
			->assertResponseStatus(301)
			->assertRedirectedTo('/contact');
	}

	public function testRedirectUses403StatusWithMiddleware() {
		$this->route->redirect('/contact_us', 'contact')
			->middleware('abort403');

		$this->get('/contact_us')
			->assertResponseStatus(403);
	}
}
