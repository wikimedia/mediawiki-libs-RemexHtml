<?php

// We intentionally test access to an undeclared property in this test case.
// @phan-file-suppress PhanUndeclaredProperty

namespace Wikimedia\RemexHtml\Tests;

use Exception;
use Wikimedia\RemexHtml\PropGuard;

/**
 * @covers \Wikimedia\RemexHtml\PropGuard
 */
class PropGuardTest extends \PHPUnit\Framework\TestCase {
	public function testArmed() {
		MockPropGuard::$armed = true;
		$mock = new MockPropGuard();
		// Should not throw
		$mock->real = true;
		// Will throw
		$this->expectException( Exception::class );
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

	/** @var bool */
	public $real;
}
