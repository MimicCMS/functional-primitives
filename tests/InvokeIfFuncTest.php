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
			array(true, array(), new Stub\InvokeTrue, 'exists', null),
			array(false, array(), new Stub\InvokeFalse, 'exists', null),
			array(array(1, 2, 3), array(1, 2, 3), Stub\InvokeTrue, 'with', null),
			array(array(3, 2, 1), array(1, 2, 3), Stub\InvokeFalse, 'with', null),
			array(null, array(), new Stub\InvokeTrue, '__doesnotexist__', null),
			array(false, array(), new Stub\InvokeTrue, '__doesnotexist__', false),
			array(true, array(), new Stub\InvokeTrue, '__doesnotexist__', true),
			array('something', array(), new Stub\InvokeTrue, '__doesnotexist__', 'something'),
			array(true, array(), '\Mimic\Test\Stub\InvokeTrue', 'method', null),
			array(false, array(), '\Mimic\Test\Stub\InvokeFalse', 'method', null),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\invokeIf
	 */
	public function testInstanceMethod_InvokeTrue($expected, $args, $obj, $methodName, $default) {
		$this->assertEquals($expected, F\invokeIf($obj, $methodName, $args, $default));
	}
}
