<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class InvokeIfFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(true, array(), new Fake\InvokeTrue, 'exists', null),
			array(false, array(), new Fake\InvokeFalse, 'exists', null),
			array(array(1, 2, 3), array(1, 2, 3), new Fake\InvokeTrue, 'with', null),
			array(array(3, 2, 1), array(1, 2, 3), new Fake\InvokeFalse, 'with', null),
			array(true, array(), '\Mimic\Test\Fake\InvokeTrue', 'method', null),
			array(false, array(), '\Mimic\Test\Fake\InvokeFalse', 'method', null),

			array(null, array(), new Fake\InvokeTrue, '__doesnotexist__', null),
			array(false, array(), new Fake\InvokeTrue, '__doesnotexist__', false),
			array(true, array(), new Fake\InvokeTrue, '__doesnotexist__', true),
			array('something', array(), new Fake\InvokeTrue, '__doesnotexist__', 'something'),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\invokeIf
	 */
	public function testInstanceMethod($expected, $args, $obj, $methodName, $default) {
		$this->assertEquals($expected, F\invokeIf($obj, $methodName, $args, $default));
	}
}
