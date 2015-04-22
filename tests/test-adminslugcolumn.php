<?php

class AdminSlugColumnTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->plugin = $GLOBALS['admin-slug-column'];
	}

	public function testTrue() {
		$this->assertTrue( true );
	}

}
