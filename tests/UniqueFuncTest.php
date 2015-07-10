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
				array(1, '1', 2, '2', 3, '3', 4, 5, 4.5, 6, '6'),
				array(1, 1, '1', 2, 2, '2', 3, '3', 4, 5, 4.5, 6, 6, '6'),
				true, null
			),
			array(
				array(1, 2, 3, 4, 5, 4.5, 6),
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
		$this->assertEquals($expected, F\unique($collection, $collection, $strict, $callback));
	}
}
