<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for attempt Mimic library function.
 *
 * @since 0.1.0
 */
class AttemptFuncTest extends PHPUnit_Framework_TestCase {

	/**
	 * @covers ::Mimic\Functional\attempt
	 */
	public function testTrueWhenCallbackIsTrue() {
		$callback = function() { return true; };
		$this->assertTrue(F\attempt($callback, $callback));
	}

	/**
	 * @covers ::Mimic\Functional\attempt
	 */
	public function testFalseWhenCallbackIsFalse() {
		$callback = function() { return false; };
		$something = function() { return 'something'; };
		$this->assertFalse(F\attempt($something, $callback));
	}

	/**
	 * @covers ::Mimic\Functional\attempt
	 */
	public function testSomethingWhenCallbackIsTrue() {
		$callback = function() { return true; };
		$something = function() { return 'something'; };
		$this->assertEquals('something', F\attempt($something, $callback));
	}
}
