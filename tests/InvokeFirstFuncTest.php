<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for invokeFirst Mimic library function.
 *
 * @since 0.1.0
 */
class InvokeFirstFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(true, array(), 'exists'),
			array(null, array(), '__doesnotexist__'),
			array(array(1, 2, 3), array(1, 2, 3), 'with'),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\invokeFirst
	 */
	public function testInstanceMethods($expected, $args, $methodName) {
		$collection = array(new Fake\InvokeTrue, new Fake\InvokeFalse);
		$this->assertEquals($expected, F\invokeFirst($collection, $methodName, $args));
	}

	/**
	 * @covers ::Mimic\Functional\invokeFirst
	 */
	public function testClassMethod() {
		$collection = array('\Mimic\Test\Fake\InvokeTrue', '\Mimic\Test\Fake\InvokeFalse');
		$this->assertTrue(F\invokeFirst($collection, 'method'));
	}
}
