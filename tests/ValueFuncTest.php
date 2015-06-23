<?php

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
			array(array()),
			array(0),
			array(1),
			array(true),
			array(false),
			array((object) array()),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\value
	 */
	public function testResults($value) {
		$this->assertEquals($value, F\value($value));
	}
}
