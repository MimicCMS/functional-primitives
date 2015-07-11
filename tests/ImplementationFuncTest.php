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
	public function testCallBackIsSame() {
		$expected = function() { return true; };
		F\implementation('test', $expected);
		$actual = F\implementation('test');
		$this->assertSame($expected, $actual);
	}

	public function testCallbackIsRemoved() {
		$expected = function() { return true; };
		F\implementation('test', $expected);
		$actual = F\implementation('test');
		$this->assertSame($expected, $actual);

		F\implementation('test', false);
		$this->assertEquals(null, F\implementation('test'));
	}
}
