<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for partialMethod Mimic library function.
 *
 * @since 0.1.0
 */
class PartialMethodFuncTest extends PHPUnit_Framework_TestCase {
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
	 * @covers ::Mimic\Functional\partialMethod
	 */
	public function testDefault() {
		$callback = F\partialMethod('__doesnotexist__', null);
		$this->assertEquals(null, $callback(new Fake\InvokeTrue));
		$this->assertEquals(null, $callback(new Fake\InvokeFalse));

		$callback = F\partialMethod('__doesnotexist__', false);
		$this->assertFalse($callback(new Fake\InvokeTrue));
		$this->assertFalse($callback(new Fake\InvokeFalse));

		$callback = F\partialMethod('__doesnotexist__', true);
		$this->assertTrue($callback(new Fake\InvokeTrue));
		$this->assertTrue($callback(new Fake\InvokeFalse));
	}

	/**
	 * @covers ::Mimic\Functional\partialMethod
	 */
	public function testEmptyArgsMethodGivesNoErrors() {
		$callback = F\partialMethod('exists');
		$this->assertTrue($callback(new Fake\InvokeTrue));
		$this->assertFalse($callback(new Fake\InvokeFalse));
	}

	/**
	 * @covers ::Mimic\Functional\partialMethod
	 */
	public function testArgumentsAreInCorrectOrder() {
		$callback = F\partialMethod('with', null, 1, 2);
		$this->assertEquals(array(1, 2, 3), $callback(new Fake\InvokeTrue, 3), 'invoke true');
		$this->assertEquals(array(3, 1, 2), $callback(new Fake\InvokeFalse, 3), 'invoke false');
	}

	/**
	 * @covers ::Mimic\Functional\partialMethod
	 */
	public function testStaticMethod() {
		$callback = F\partialMethod('method');
		$this->assertTrue($callback('\Mimic\Test\Fake\InvokeTrue'));
		$this->assertFalse($callback('\Mimic\Test\Fake\InvokeFalse'));
	}
}
