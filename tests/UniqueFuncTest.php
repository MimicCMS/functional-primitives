<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for unique Mimic library function.
 *
 * @since 0.1.0
 */
class UniqueFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(
				array(0 => 1, 2 => '1', 3 => 2, 5 => '2', 6 => 3, 7 => '3', 8 => 4, 9 => 5, 10 => 4.5, 11 => 6, 13 => '6'),
				array(1, 1, '1', 2, 2, '2', 3, '3', 4, 5, 4.5, 6, 6, '6'),
				true, null
			),
			array(
				array(0 => 1, 3 => 2, 6 => 3, 8 => 4, 9 => 5, 10 => 4.5, 11 => 6),
				array(1, 1, '1', 2, 2, '2', 3, '3', 4, 5, 4.5, 6, 6, '6'),
				false, null
			),
			array(
				array(1),
				array(1, 1, '1', 2, 2, '2', 3, '3', 4, 5, 4.5, 6, 6, '6'),
				false,
				function() { return 1; }
			),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\unique
	 */
	public function testResults($expected, $collection, $strict, $callback) {
		$this->assertEquals($expected, F\unique($collection, $strict, $callback));
	}
}
