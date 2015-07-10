<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class SomeFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\some
	 */
	public function testNotFound() {
		$collection = array(1, 3, 5, 7);
		$callback = function($element) {
			return ($element % 2) === 0;
		};
		$this->assertFalse(F\some($collection, $callback));
	}

	/**
	 * @covers ::Mimic\Functional\some
	 */
	public function testFound() {
		$collection = array(2, 4, 6, 8);
		$callback = function($element) {
			return ($element % 2) === 0;
		};
		$this->assertTrue(F\some($collection, $callback));
	}
}
