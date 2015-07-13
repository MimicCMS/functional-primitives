<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

use ArrayIterator;

/**
 * Unit Test for forgetFirst Mimic library function.
 *
 * @since 0.1.0
 */
class ForgetFirstFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(1, 2, 3), array(1, 2, 3), array(2, 3)),
			array(new ArrayIterator(array(1, 2, 3)), array(1, 2, 3), array(2, 3)),
			array(array('something', 'else'), array('something', 'else'), array('else')),
			array(array('else'), array('else'), array()),
			array(array(), array(), array()),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\forgetFirst
	 */
	public function testResults($collection, $check, $expected) {
		$this->assertEquals($expected, F\forgetFirst($collection));
		$this->assertSame($check, $collection, 'collection has changed');
	}
}
