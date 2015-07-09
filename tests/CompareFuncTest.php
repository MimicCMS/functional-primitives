<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for true Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class CompareFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(true, 1, 1, true),
			array(false, 1, true, true),
			array(false, '1', 1, true),
			array(true, '1', 1, false),
			array(false, 0, 1, true),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\compare
	 */
	public function testResults($expected, $check, $value, $strict) {
		$callback = F\compare($value, $strict);
		$this->assertEquals($expected, $callback($check));
	}
}
