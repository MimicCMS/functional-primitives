<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for value Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class ValueFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(), array()),
			array(0, 0),
			array(1, 1),
			array(true, true),
			array(false, false),
			array((object) array(), (object) array()),
			array(true, function() { return true; }),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\value
	 */
	public function testResults($expected, $value) {
		$this->assertEquals($expected, F\value($value));
	}
}
