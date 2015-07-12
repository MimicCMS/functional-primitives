<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

use ArrayIterator;

/**
 * Unit Test for flatten Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class FlattenFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(1, 2, 3, 1, 2, 3), array(1, 2, 3, array(1, 2, 3))),
			array(array('hello', 'world', 'something', 'else'), array('hello', 'world', array('something', 'else'))),
			array(array(1, 2, 3, 0, 'else'), array(0 => 1, 4 => 2, 5 => 3, array(1 => 0, 'something' => 'else'))),
			array(array(1, 2, 3, 4, 5, 6), new ArrayIterator(array(1, 2, 3, array(4, 5, 6)))),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\flatten
	 */
	public function testResults($expected, $collection) {
		$this->assertEquals($expected, F\flatten($collection));
	}
}
