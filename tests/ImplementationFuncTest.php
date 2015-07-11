<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for implementation Mimic library function.
 *
 * @since 0.1.0
 */
class ImplementationFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\implementation
	 */
	public function testCallBackIsSame() {
		$expected = function() { return true; };
		F\implementation('test', $expected);
		$actual = F\implementation('test');
		$this->assertSame($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\implementation
	 */
	public function testCallbackIsRemoved() {
		$expected = function() { return true; };
		F\implementation('test', $expected);
		$actual = F\implementation('test');
		$this->assertSame($expected, $actual);

		F\implementation('test', false);
		$this->assertEquals(null, F\implementation('test'));
	}
}
