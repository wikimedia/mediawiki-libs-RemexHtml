<?php

namespace RemexHtml\Tests;

use Exception;
use RemexHtml\PropGuard;

class PropGuardTest extends \PHPUnit_Framework_TestCase {
	public function testArmed() {
		MockPropGuard::$armed = true;
		$mock = new MockPropGuard();
		// Should not throw
		$mock->real = true;
		// Will throw
		$this->setExpectedException( Exception::class );
		$mock->fake = true;
	}

	public function testDisarmed() {
		MockPropGuard::$armed = false;
		$mock = new MockPropGuard();
		$mock->fake = true;
		$this->assertTrue( $mock->fake );
	}

}

class MockPropGuard {
	use PropGuard;

	public $real;
}
