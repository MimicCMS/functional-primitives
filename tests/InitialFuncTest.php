<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;
use ArrayIterator;

/**
 * Unit Test for initial Mimic library function.
 *
 * @since 0.1.0
 */
class InitialFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4);
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
	 * @covers ::Mimic\Functional\initial
	 */
	public function testResults($drop, $collection, $expected) {
		$this->assertEquals($expected, F\initial($collection, $drop));
	}
}
