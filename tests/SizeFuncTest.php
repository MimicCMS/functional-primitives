<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;
use ArrayIterator;

/**
 * Unit Test for size Mimic library function.
 *
 * @since 0.1.0
 */
class SizeFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider_zero() {
		return array(
			array(null),
			array('something'),
			array(1),
			array(1.0),
			array((object) array()),
		);
	}

	public function dataProvider_countable() {
		return array(
			array(0, array()),
			array(1, array(1)),
			array(2, array(1, 2)),
			array(0, new Fake\SizeCount(0)),
			array(1, new Fake\SizeCount(1)),
			array(2, new Fake\SizeCount(2)),
			array(0, new Fake\Size(0)),
			array(1, new Fake\Size(1)),
			array(2, new Fake\Size(2)),
			array(3, new Fake\Size(3)),
			array(4, new Fake\Size(4)),
			array(5, new Fake\Size(5)),
		);
	}

	/**
	 * @dataProvider dataProvider_zero
	 * @covers ::Mimic\Functional\size
	 */
	public function testZeroAmount($value) {
		$this->assertEquals(0, F\size($value));
	}

	/**
	 * @dataProvider dataProvider_countable
	 * @covers ::Mimic\Functional\size
	 */
	public function testCountable($expected, $value) {
		$this->assertEquals($expected, F\size($value));
	}
}
