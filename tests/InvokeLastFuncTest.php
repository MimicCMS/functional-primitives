<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for invokeLast Mimic library function.
 *
 * @since 0.1.0
 */
class InvokeLastFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(false, array(), 'exists'),
			array(null, array(), '__doesnotexist__'),
			array(array(3, 2, 1), array(1, 2, 3), 'with'),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\invokeLast
	 */
	public function testInstanceMethods($expected, $args, $methodName) {
		$collection = array(new Fake\InvokeTrue, new Fake\InvokeFalse);
		$this->assertEquals($expected, F\invokeLast($collection, $methodName, $args));
	}

	/**
	 * @covers ::Mimic\Functional\invokeLast
	 */
	public function testClassMethod() {
		$collection = array('\Mimic\Test\Fake\InvokeTrue', '\Mimic\Test\Fake\InvokeFalse');
		$this->assertFalse(F\invokeLast($collection, 'method'));
	}
}
