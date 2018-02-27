<?php

namespace RemexHtml\Tests;

use Exception;
use RemexHtml\PropGuard;

class PropGuardTest extends \PHPUnit\Framework\TestCase {
	public function testArmed() {
		MockPropGuard::$armed = true;
		$mock = new MockPropGuard();
		// Should not throw
		$mock->real = true;
		// Will throw
		if ( is_callable( [ $this, 'expectException' ] ) ) {
			// PHPUnit 6+
			$this->expectException( Exception::class );
		} else {
			// PHPUnit 4.8
			$this->setExpectedException( Exception::class );
		}
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
