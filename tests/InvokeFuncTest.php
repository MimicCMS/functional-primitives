<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for invoke Mimic library function.
 *
 * @since 0.1.0
 */
class InvokeFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(true, false), array(), 'exists'),
			array(array(null, null), array(), '__doesnotexist__'),
			array(array(array(1, 2, 3), array(3, 2, 1)), array(1, 2, 3), 'with'),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\invoke
	 */
	public function testInstanceMethods($expected, $args, $methodName) {
		$collection = array(new Stub\InvokeTrue, new Stub\InvokeFalse);
		$this->assertEquals($expected, F\invoke($collection, $methodName, $args));
	}

	/**
	 * @covers ::Mimic\Functional\invoke
	 */
	public function testClassMethod() {
		$collection = array('\Mimic\Test\Stub\InvokeTrue', '\Mimic\Test\Stub\InvokeFalse');
		$expected = array(true, false);
		$actual = F\invoke($collection, 'method');
		$this->assertEquals($expected, $actual);
	}
}
