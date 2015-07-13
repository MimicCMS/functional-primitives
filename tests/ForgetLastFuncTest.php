<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for forgetLast Mimic library function.
 *
 * @since 0.1.0
 */
class ForgetLastFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(1, 2, 3), array(1, 2, 3), array(1, 2)),
			array(new ArrayIterator(array(1, 2, 3)), array(1, 2, 3), array(1, 2)),
			array(array('something', 'else'), array('something', 'else'), array('something')),
			array(array('else'), array('else'), array()),
			array(array(), array(), array()),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\forgetLast
	 */
	public function testResults($collection, $check, $expected) {
		$this->assertEquals($expected, F\forgetLast($collection));
		$this->assertSame($check, $collection, 'collection has changed');
	}
}
