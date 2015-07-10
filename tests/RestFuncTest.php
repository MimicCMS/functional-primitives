<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;
use ArrayIterator;

/**
 * Unit Test for rest Mimic library function.
 *
 * @since 0.1.0
 */
class RestFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
		return array(
			array(2, $collection, $expected),
			array(-2, $collection, $expected),
			array(8, $collection, array()),
			array(2, new ArrayIterator($collection), $expected),
			array(-2, new ArrayIterator($collection), $expected),
			array(8, new ArrayIterator($collection), array()),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\rest
	 */
	public function testResults($drop, $collection, $expected) {
		$this->assertEquals($expected, F\rest($collection, $drop));
	}
}
