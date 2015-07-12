<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for sortable Mimic library function.
 *
 * @since 0.1.0
 */
class SortableFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(0, 0, 0, false),
			array(0, 1, '1', false),
			array(-1, 1, 2, false),
			array(-1, 1, '2', false),
			array(-1, '1', '2', false),
			array(1, 2, 1, false),
			array(0, 0, 0, true),
			array(0, 1, '1', true),
			array(1, 1, 2, true),
			array(1, 1, '2', true),
			array(1, '1', '2', true),
			array(-1, 2, 1, true),
			array(0, 'something', 'something', false),
			array(-1, 'hello', 'world', false),
			array(1, 'world', 'hello', false),
			array(0, 'something', 'something', true),
			array(1, 'hello', 'world', true),
			array(-1, 'world', 'hello', true),
			array(0, array(), array(), false),
			array(0, array(), array(), true),
			array(-1, 1, array(), false),
			array(1, 1, array(), true),
			array(1, array(), 1, false),
			array(-1, array(), 1, true),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\sortable
	 */
	public function testIntegers($expected, $left, $right, $reversed) {
		$callback = F\sortable($reversed);
		$this->assertEquals($expected, $callback($left, $right));
	}
}
